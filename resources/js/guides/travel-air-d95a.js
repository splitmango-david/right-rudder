/*
 * Beech D95A Travel Air study guide: tabs, airspeed dial, checklists,
 * performance tables and the quiz/flashcards.
 */
(function(){
const $=s=>document.querySelector(s), $$=s=>[...document.querySelectorAll(s)];
const store={get(k,d){try{const v=localStorage.getItem(k);return v?JSON.parse(v):d}catch(e){return d}},set(k,v){try{localStorage.setItem(k,JSON.stringify(v))}catch(e){}}};

/* ---------- Tabs ---------- */
const views=$$('#tablist button').map(b=>b.dataset.v);
function show(v){
  if(!views.includes(v)) v='overview';
  views.forEach(x=>{$('#v-'+x).hidden=(x!==v)});
  $$('#tablist button').forEach(b=>b.setAttribute('aria-selected',b.dataset.v===v));
  const btn=$(`#tablist button[data-v="${v}"]`); btn&&btn.scrollIntoView({block:'nearest',inline:'nearest'});
  store.set('travel-air.tab',v);
}
$$('#tablist button').forEach(b=>b.addEventListener('click',()=>{show(b.dataset.v);try{history.replaceState(null,'','#'+b.dataset.v)}catch(e){};window.scrollTo({top:0})}));
show((location.hash||'').slice(1)||store.get('travel-air.tab','overview'));

/* ---------- ASI ---------- */
(function(){
  const svg=$('#asi'), NS='http://www.w3.org/2000/svg', cx=170, cy=170;
  const MIN=40, MAX=240, A0=-150, A1=150; // degrees from 12 o'clock
  const ang=k=>A0+(Math.min(Math.max(k,MIN),MAX)-MIN)/(MAX-MIN)*(A1-A0);
  const pt=(a,r)=>{const t=(a-90)*Math.PI/180;return [cx+r*Math.cos(t),cy+r*Math.sin(t)]};
  const el=(n,at)=>{const e=document.createElementNS(NS,n);for(const k in at)e.setAttribute(k,at[k]);svg.appendChild(e);return e};
  const arc=(k0,k1,r,w,col)=>{const a=ang(k0),b=ang(k1),[x0,y0]=pt(a,r),[x1,y1]=pt(b,r);el('path',{d:`M${x0} ${y0} A${r} ${r} 0 ${b-a>180?1:0} 1 ${x1} ${y1}`,fill:'none',stroke:col,'stroke-width':w})};
  el('circle',{cx,cy,r:166,fill:'var(--dial)',stroke:'var(--line)','stroke-width':2});
  arc(61,113,112,7,'var(--arc-white)');
  arc(71,161,123,9,'var(--arc-green)');
  arc(161,208,123,9,'var(--arc-yellow)');
  const radial=(k,col,w)=>{const [x0,y0]=pt(ang(k),117),[x1,y1]=pt(ang(k),146);el('line',{x1:x0,y1:y0,x2:x1,y2:y1,stroke:col,'stroke-width':w,'stroke-linecap':'butt'})};
  for(let k=MIN;k<=MAX;k+=10){const major=k%20===0;const [x0,y0]=pt(ang(k),major?132:137),[x1,y1]=pt(ang(k),146);el('line',{x1:x0,y1:y0,x2:x1,y2:y1,stroke:'var(--dial-ink)','stroke-width':major?2:1});
    if(major){const [tx,ty]=pt(ang(k),94);const t=el('text',{x:tx,y:ty+5,'text-anchor':'middle',fill:'var(--dial-ink)','font-family':'Space Mono, monospace','font-size':14,'font-weight':600});t.textContent=k}}
  radial(208,'var(--arc-red)',5); radial(94,'var(--arc-blue)',5);
  const lab=(txt,y,s,w)=>{const t=el('text',{x:cx,y,'text-anchor':'middle',fill:'var(--dial-ink)','font-family':'Fredoka, sans-serif','font-size':s,'font-weight':w,'letter-spacing':2});t.textContent=txt};
  lab('KNOTS',150,13,600); lab('AIRSPEED',214,11,500);
  // needle at blue line
  const [nx,ny]=pt(ang(94),128); el('line',{x1:cx,y1:cy,x2:nx,y2:ny,stroke:'var(--dial-ink)','stroke-width':4,'stroke-linecap':'round'});
  el('circle',{cx,cy,r:9,fill:'var(--dial-ink)'});
})();

/* ---------- Checklists ---------- */
const CL=[
 {t:'Before starting',p:'131',items:[
  ['Preflight inspection','COMPLETE'],['Loading, fuel & oil quantity','CHECKED'],['Turbocharger controls','OFF · Rajay',1],['Parking brake','SET'],
  ['Battery and generator/alternator switches','ON (OFF if external power)'],['Turbo oil warning lights','ON with master · Rajay',1],
  ['All switches, breakers, controls','CHECKED'],['Landing gear switch','DOWN · mech. indicator full'],['Cowl flaps','OPEN'],
  ['Fuel selectors','MAIN or AUX'],['Alternate air controls','IN (normal)'],['Gear and flap position lights','CHECKED']]},
 {t:'Starting',p:'131',items:[
  ['Throttles','¼ OPEN'],['Propeller controls','HIGH RPM'],['Normal: mixture','FULL RICH'],['Normal: aux fuel pump','ON until fuel flow, then OFF'],['Normal: starter','ENGAGE'],
  ['Hot/flooded: mixture','IDLE CUT-OFF'],['Hot/flooded: starter','ENGAGE; mixture rich when it fires'],
  ['Oil pressure','WITHIN 30 SEC'],['Warm-up','800–1300 RPM; gauges normal'],['Other engine','START'],['External power (if used)','DISCONNECT; battery & gen/alt ON']]},
 {t:'Before takeoff',p:'131–132',items:[
  ['Propellers','EXERCISE at 2200; set HIGH RPM'],['Fuel flow check','Purge vapor from all tanks; MAIN for takeoff'],
  ['Magnetos at 2000 rpm','125 RPM MAX DROP'],['Feathering check at 1500 rpm','500 RPM MAX DROP'],
  ['Turbo check at 2200 rpm','Boost rises, ≤28.5 in., then OFF · Rajay',1],['Turbo oil lights','OFF · Rajay',1],
  ['Flight controls','FREE & FULL TRAVEL'],['Aux fuel pumps','AS REQUIRED'],['Mixtures','FULL RICH (lean for TO power above 3000 ft)'],
  ['Trim','SET for takeoff'],['Alternate air','OFF'],['Instruments; altimeter & gyro','CHECKED / SET'],['Flaps','AS REQUIRED (20° short field)'],
  ['Turbo controls (normal T/O)','OFF · Rajay',1],['Doors & windows','LOCKED'],['Seat belts','FASTENED'],['Parking brake','OFF']]},
 {t:'Before landing',p:'132',items:[
  ['Seat belts','FASTENED'],['Main cell quantity','CHECK; both selectors MAIN'],['Turbochargers','OFF · Rajay',1],['Mixtures','FULL RICH'],
  ['Landing gear','DOWN; check indicators'],['Aux fuel pumps','AS REQUIRED'],['Flaps','AS REQUIRED'],['Cowl flaps','CLOSED until on ground'],['Propellers','HIGH RPM']]},
 {t:'Shutdown',p:'132',items:[
  ['If turbos were used','OFF ≥2 MIN before shutdown · Rajay',1],['Parking brake','SET'],['Electrical & radio','OFF'],['Propellers','HIGH RPM'],['Aux fuel pumps','OFF'],
  ['Throttles','~1100 RPM'],['Mixtures','IDLE CUT-OFF'],['Ignition','OFF after engine stops'],['Battery & gen/alt switches','OFF'],
  ['Fuel selectors','OFF if parked for long'],['Controls','LOCKED if warranted']]}
];
const ticks=store.get('travel-air.ticks',{});
function renderCL(){
  $('#checklists').innerHTML=CL.map((c,ci)=>`<div class="card"><div class="card-head"><h3>${c.t}</h3><span class="src">${c.p}</span></div><ol class="cl">${c.items.map((it,ii)=>{const id=`c${ci}_${ii}`,on=!!ticks[id];return `<li class="${on?'done':''}"><input type="checkbox" id="${id}" ${on?'checked':''}><label for="${id}"><span class="itm">${it[0]}</span> — <span class="act">${it[1]}</span></label></li>`}).join('')}</ol></div>`).join('');
}
renderCL();
$('#checklists').addEventListener('change',e=>{if(e.target.type!=='checkbox')return;ticks[e.target.id]=e.target.checked;e.target.closest('li').classList.toggle('done',e.target.checked);store.set('travel-air.ticks',ticks)});
$('#clReset').addEventListener('click',()=>{for(const k in ticks)delete ticks[k];store.set('travel-air.ticks',ticks);renderCL()});

/* ---------- Performance ---------- */
const PERF={
 to:{t:'Takeoff over 50 ft (ft)',s:'Takeoff power, flaps up, 85 mph CAS',rows:[[1748,1931,2117,2308,2533],[2090,2313,2549,2785,3054],[2531,2788,3075,3376,3708],[3046,3404,3771,4167,4588],[3773,4204,4696,5190,5794]]},
 ld:{t:'Landing over 50 ft (ft)',s:'Flaps full down, 91 mph CAS approach',rows:[[2021,2096,2178,2252,2331],[2127,2211,2294,2377,2449],[2245,2331,2416,2499,2579],[2369,2457,2543,2635,2713],[2499,2588,2673,2754,2840]]},
 cl:{t:'Two-engine climb (fpm)',s:'Max continuous, flaps up, 110 mph CAS at SL',rows:[[1357,1307,1263,1219,1170],[1219,1169,1120,1077,1033],[1083,1047,991,946,900],[973,902,854,807,755],[815,764,708,660,603]]},
 bk:{t:'Balked landing climb (fpm)',s:'Takeoff power, gear & flaps down, 81.5 mph CAS',rows:[[827,775,728,682,627],[694,642,589,544,499],[558,516,457,412,362],[445,374,325,276,224],[289,237,181,134,78]]},
 se:{t:'Single-engine climb (fpm)',s:'Max continuous, clean, feathered, 108 mph CAS at SL',rows:[[281,247,217,188,153],[202,170,136,108,78],[125,98,62,33,2],[61,17,-15,-46,-79],[-27,-61,-97,-129,-163]]}
};
const ALTS=['SL','2,000','4,000','6,000','8,000'], OATS=['0°F','25°F','50°F','75°F','100°F'];
function renderPerf(){
  const a=+$('#pAlt').value,o=+$('#pOat').value;
  $('#perfTiles').innerHTML=Object.values(PERF).map(p=>{const v=p.rows[a][o];const neg=v<=0&&p.t.includes('Single');return `<div class="vt" style="--stripe:${neg?'var(--arc-red)':'var(--accent)'}"><span class="lbl">${p.t}</span><span class="k">${v.toLocaleString()}</span><span class="m">${ALTS[a]} ft · ${OATS[o]}</span></div>`}).join('');
  $('#perfTables').innerHTML=Object.values(PERF).map(p=>`<div class="card"><div class="card-head"><h3>${p.t}</h3><span class="src">154</span></div><p class="hint">${p.s}</p><div class="tbl"><table><thead><tr><th>Alt</th>${OATS.map((x,j)=>`<th class="n"${j===o?' style="color:var(--accent)"':''}>${x}</th>`).join('')}</tr></thead><tbody>${p.rows.map((r,i)=>`<tr><td class="mono"${i===a?' style="color:var(--accent);font-weight:600"':''}>${ALTS[i]}</td>${r.map((v,j)=>`<td class="n"${i===a&&j===o?' style="background:var(--accent);color:var(--accent-ink);font-weight:700"':(v<=0?' style="color:var(--bad)"':'')}>${v}</td>`).join('')}</tr>`).join('')}</tbody></table></div></div>`).join('');
}
$('#pAlt').addEventListener('change',renderPerf);$('#pOat').addEventListener('change',renderPerf);renderPerf();

/* ---------- Quiz ---------- */
const Q=[
// Limitations
['Limitations','What is V<sub>NE</sub> for this airplane?',['208 kt (240 mph) CAS','185 kt CAS','161 kt (185 mph) CAS','226 kt CAS'],0,'Red radial, 208 kt / 240 mph CAS. 161 kt is the top of the green arc.','152'],
['Limitations','Maximum flap extension speed?',['113 kt (130 mph)','139 kt (160 mph)','143 kt (165 mph)','100 kt (115 mph)'],0,'Top of the white arc: 113 kt / 130 mph CAS.','152'],
['Limitations','Maximum gear-down speed in normal operation?',['143 kt (165 mph)','113 kt (130 mph)','161 kt (185 mph)','174 kt (200 mph)'],0,'143 kt / 165 mph. 174 kt (200 mph) IAS is the extreme-emergency gear-lowering speed only.','152, 72'],
['Limitations','In an extreme emergency the gear may be lowered at up to…',['174 kt (200 mph) IAS','143 kt (165 mph) IAS','208 kt (240 mph) IAS','161 kt (185 mph) IAS'],0,'Up to 200 mph (174 kt) IAS, then inspect the gear doors and supporting structure.','72'],
['Limitations','Design maneuvering speed V<sub>A</sub>?',['139 kt (160 mph)','143 kt (165 mph)','113 kt (130 mph)','161 kt (185 mph)'],0,'160 mph / 139 kt CAS at 4200 lb.','152'],
['Limitations','V<sub>MC</sub> per the AFM?',['69.5 kt (80 mph) CAS','61 kt (70 mph) CAS','85 kt (98 mph) CAS','74 kt (85 mph) CAS'],0,'Minimum single-engine control speed is 80 mph (69.5 kt) CAS.','153'],
['Limitations','Maximum takeoff weight?',['4200 lb','4000 lb','4300 lb','3600 lb'],0,'Max weight 4200 lb.','152'],
['Limitations','Aft CG limit?',['86.0 in. aft of datum at all weights','80.5 in. at 4200 lb','75.0 in. up to 3600 lb','88.0 in. at all weights'],0,'Aft limit 86 in. at all weights. 75.0 and 80.5 in. are the forward limits.','152'],
['Limitations','Positive maneuvering load-factor limit at 4200 lb?',['+4.4 G','+3.8 G','+4.32 G','+6.0 G'],0,'+4.4 G / −3.0 G maneuver. +4.32 G is the gust limit.','152'],
['Limitations','Maximum bank angle for normal-category maneuvers?',['60°','45°','30°','There is no limit'],0,'Turns not exceeding 60° bank. Stalls allowed except whip stalls; spins prohibited.','51'],
['Limitations','Naturally aspirated engine limit?',['2700 rpm and 29.0 in. MP, all operations','2700 rpm and 28.5 in., 5 minutes','2600 rpm and 28.0 in. continuous','2450 rpm and 25 in. continuous'],0,'2700 rpm, 29.0 in. (180 hp) for all operations.','152'],
['Limitations','CHT red line?',['500 °F','460 °F','435 °F','245 °F'],0,'Green 200–500 °F, red radial 500 °F. 245 °F is the oil temperature red line.','152'],
['Limitations','Oil pressure ranges?',['Red 25 psi idle min; green 65–85; red 85','Red 10 psi; green 30–60; red 100','Green 50–90; red 90','Red 25; green 25–85'],0,'Minimum idling 25 psi, green 65–85, max 85 psi.','152'],
['Limitations','With the Rajay turbos installed, the minimum fuel grade is…',['100/130','91/96','80/87','115/145 only'],0,'Rajay AFMS: 100/130 minimum. The basic AFM allows 91/96. Never 80/87.','163'],
// Speeds
['Speeds','Blue line (V<sub>YSE</sub>) at sea level?',['94 kt (108 mph)','85 kt (98 mph)','95.5 kt (110 mph)','89.5 kt (103 mph)'],0,'108 mph / 94 kt, blue radial. Reduce about 1 mph per 1000 ft.','153'],
['Speeds','V<sub>XSE</sub> at sea level?',['85 kt (98 mph)','94 kt (108 mph)','72 kt (83 mph)','78 kt (90 mph)'],0,'Best single-engine angle of climb: 98 mph / 85 kt IAS.','38'],
['Speeds','Normal takeoff (liftoff) speed?',['74 kt (85 mph)','61 kt (70 mph)','79 kt (91 mph)','87 kt (100 mph)'],0,'85 mph / 74 kt, 0° flaps. Short field is 70 mph / 61 kt with 20° flaps.','38'],
['Speeds','Normal approach speed at 50 ft?',['79 kt (91 mph)','74 kt (85 mph)','65 kt (75 mph)','87 kt (100 mph)'],0,'91 mph / 79 kt. Short-field approach is 85 mph / 74 kt; contact 75 mph / 65 kt.','39'],
['Speeds','Power-off stall, gear and flaps up, wings level, 4200 lb (IAS)?',['73.5 kt','65.0 kt','53.0 kt','61.0 kt'],0,'85 mph / 73.5 kt. Gear and flaps down: 75 mph / 65 kt.','39'],
['Speeds','Maximum altitude lost in a stall, per the AFM?',['About 300 ft','About 100 ft','About 500 ft','About 1000 ft'],0,'Approximately 300 ft.','154'],
['Speeds','Best glide in zero wind?',['120 mph IAS, about 13.6:1','108 mph IAS, about 10:1','130 mph IAS, about 17:1','98 mph IAS, about 12:1'],0,'120 mph IAS zero wind, 13.6:1, roughly 2.5 statute miles per 1000 ft. Props feathered, everything up.','41, 73'],
// Systems
['Systems','Usable fuel in each 40-gal main tank, per the 1972 supplement?',['37 gal','40 gal','35 gal','38 gal'],0,'The 1972 supplement: 37 gal from a 39 or 40 gal main; 22 gal from a 25 gal main.','1'],
['Systems','Usable fuel in each 25-gal main tank, per the 1972 supplement?',['22 gal','25 gal','20 gal','23 gal'],0,'22 gal usable.','1'],
['Systems','Both engines running, you put the LEFT selector on crossfeed. What happens?',['Both engines feed from the tank selected on the right valve','Each engine still feeds its own wing','The left engine starves','Fuel transfers from left to right wing'],0,'If one selector is on crossfeed with both engines running, both feed from the same tank, the one chosen on the other valve.','153, 49'],
['Systems','When may aux tanks and crossfeed be used?',['Level flight only','Any phase except takeoff','Climb and cruise','Only in an emergency'],0,'Placard: "Use aux tanks and crossfeed in level flight only." Take off and land on mains.','153'],
['Systems','Which tank does the cabin heater burn?',['Left main','Right main','Either aux','Whichever is selected for the left engine'],0,'Heater fuel comes from the left main wing tank.','23'],
['Systems','How is the gear held down?',['Over-center linkage, spring-loaded; no downlocks','Hydraulic downlocks','Mechanical downlock pins','Motor holding torque'],0,'No downlocks are needed; the over-center linkage forms a positive geometric lock.','11'],
['Systems','Where is the gear safety (squat) switch?',['Left main strut','Nose strut','Right main strut','Both mains'],0,'Left main strut. Never rely on it; check the handle position.','11'],
['Systems','What drives the props toward feather?',['Feathering spring and blade counterweights','Governor-boosted oil pressure','Aerodynamic twisting moment only','An electric motor'],0,'Spring and counterweights increase pitch; boosted oil decreases it. Losing oil pressure feathers the prop.','13, 46'],
['Systems','Manual gear extension: how many turns, which way?',['About 50 turns counterclockwise','About 30 turns clockwise','About 50 turns clockwise','About 15 turns counterclockwise'],0,'Breaker pulled, switch DOWN, crank counterclockwise as far as possible, about 50 turns. Lowering only.','153'],
['Systems','Flap positions available?',['Up, 10°, 20°, 28°','Up, 15°, 30°','Up, 10°, 20°, 30°, 40°','Up, approach, full (35°)'],0,'Intermediate 10° and 20° marked on the left flap; full down is 28°.','10'],
['Systems','Oil capacity per engine and absolute minimum?',['8 qt; minimum 2 qt','6 qt; minimum 3 qt','8 qt; minimum 4 qt','12 qt; minimum 6 qt'],0,'8-quart sump, 2 quart absolute minimum.','16, 103'],
['Systems','Under the 1968 AFMS, when is a turning takeoff prohibited with 40-gal mains?',['Either main has less than 25 gal','Either main has less than 10 gal','Aux tanks are empty','Fuel imbalance exceeds 10 gal'],0,'No turning takeoff (or right after a fast taxi turn) if a 40-gal main has under 25 gal, or a 25-gal main under 5 gal.','156'],
// Procedures
['Procedures','Maximum mag drop at 2000 rpm?',['125 rpm','175 rpm','100 rpm','50 rpm'],0,'Maximum drop 125 rpm.','45'],
['Procedures','Feathering check during run-up?',['At 1500 rpm, max 500 rpm drop','At 2200 rpm, max 300 rpm drop','At 1000 rpm, full feather','Not done on the ground'],0,'Reduce to 1500 rpm and check feathering action; don\'t let rpm drop more than 500.','45, 131'],
['Procedures','Cranking limits for the starters?',['10–12 s, then 5 min cooling','30 s, then 1 min cooling','60 s continuous','5 s, then 30 s cooling'],0,'Limit each crank to 10–12 seconds; a 5-minute cooling interval extends starter life.','44'],
['Procedures','The cabin door pops open just after liftoff. What does the book say?',['Ignore it and return to the field normally; it trails 3–4 in.','Slow below 100 mph and close it','Reject the takeoff at any cost','Open the storm window to equalize pressure'],0,'Flight characteristics are unaffected; the door trails 3–4 in. open without buffet.','47'],
['Procedures','Hot weather fuel vapor: what does the manual recommend?',['Start and warm up on aux; mains for pre-takeoff and takeoff; hold at 800–1000 rpm','Start on mains with mixture lean','Never use boost pumps on the ground','Take off on aux tanks'],0,'Avoid long ground runs, hold at 800–1000 rpm, start and warm up on aux, return to mains for checks and takeoff.','58'],
// Emergencies
['Emergencies','How should you NOT identify the failed engine?',['By tachometer or manifold pressure','By dead foot','By CHT','By retarding the suspect throttle'],0,'Tach can show normal rpm and MP near atmospheric on a failed engine.','64'],
['Emergencies','Engine failure on takeoff, runway insufficient, below V<sub>XSE</sub>. Action?',['Throttles closed, battery/gen off, fuel off, straight ahead','Feather and climb at V<sub>YSE</sub>','Gear up and accelerate in ground effect','Turn back to the runway'],0,'Case B: close throttles, battery and generator OFF, fuel selectors OFF, continue straight ahead turning only to avoid obstacles.','66'],
['Emergencies','In the single-engine procedure, bank how much and which way?',['About 5° toward the operating engine','About 5° toward the dead engine','Wings level only','About 15° toward the operating engine'],0,'Bank approximately 5° into the heavy rudder, which is the good engine side.','65'],
['Emergencies','Single-engine go-around with full flaps. Flap action?',['Retract to about half flap, the rest as soon as practicable','Retract fully at once','Leave them down until 500 ft','Extend to full if not already'],0,'Full power, hold V<sub>YSE</sub>, gear up, dead cowl flap closed, flaps to about half, rest later.','69'],
['Emergencies','After an in-flight restart, warm the engine at…',['About 2000 rpm and 15 in. MP','Idle','2450 rpm and 25 in.','Full power immediately'],0,'Warm up at approximately 2000 rpm and 15 in.; oil pressure normal within 30 s or refeather.','68'],
['Emergencies','First item for an engine fire in flight?',['Fuel selector OFF','Mixture idle cut-off','Prop feather','Ignition OFF'],0,'Fuel selector OFF, mixture idle cut-off, prop feather, boost pump off, ignition off, generator off. Land immediately.','73'],
['Emergencies','With gear and full flaps down on one engine at gross weight…',['Level flight cannot be maintained','You can climb at V<sub>YSE</sub>','You can hold altitude at V<sub>XSE</sub>','Only the gear must come up'],0,'The book is explicit: level flight cannot be maintained; don\'t go around unless there\'s time to clean up.','69'],
['Emergencies','Using the emergency static source, airspeed and altimeter generally read…',['High','Low','Correctly','Erratically, unusable'],0,'Both generally read high; the AFMS calibration table gives the corrections.','57, 155'],
// Supplements
['Supplements','Rajay turbocharged takeoff rating?',['28.5 in., 2700 rpm, 3 minutes','29.0 in., 2700 rpm, 5 minutes','28.0 in., 2600 rpm, no limit','30.0 in., 2700 rpm, 1 minute'],0,'28.5 in. / 2700 rpm, 3 minutes (3,500–12,000 ft). Max continuous 28.0 in. / 2600.','163'],
['Supplements','Rajay: above what altitude must the boost pumps be ON?',['8,000 ft MSL','5,000 ft MSL','12,000 ft MSL','20,000 ft MSL'],0,'Placard: fuel boost pumps ON above 8,000 ft MSL.','163'],
['Supplements','Turbo oil pressure warning light comes on in cruise. Action?',['Pull that turbo control OFF and continue on normal power','Shut down and feather that engine','Reduce to idle and descend','Ignore it above 10,000 ft'],0,'Turbo control OFF on the affected engine, continue normally aspirated, watch oil pressure/temperature.','166'],
['Supplements','After a turbocharged landing, how long before shutdown?',['At least 2 minutes with turbos off','30 seconds','5 minutes at 1500 rpm','No wait needed'],0,'Turbos are lubricated by engine oil; 2 minutes lets them spin down.','165'],
['Supplements','Rajay: V<sub>NE</sub> reduction above 20,000 ft?',['6 mph (5 kt) per 1000 ft','10 mph per 1000 ft','2% per 1000 ft','None'],0,'Placard: reduce V<sub>NE</sub> 6 mph (5 kt) per 1000 ft above 20,000 ft MSL.','163'],
['Supplements','Rajay: minimum turbocharged climb speeds?',['120 mph two engines, 110 mph one engine','110 mph two engines, 98 mph one engine','140 mph both cases','108 mph both cases'],0,'Minimum climb speed 120 mph IAS with both engines, 110 mph IAS with one.','165'],
['Supplements','Century III autopilot: which is NOT authorized?',['Single-engine missed approach','Coupled ILS approach','Altitude hold in cruise','Use with one engine inoperative in cruise'],0,'Single-engine missed approach operations are not authorized. AP off for takeoff and landing; max 200 mph CAS.','157, 159'],
['Supplements','Autopilot malfunction in cruise with a 3-second recognition delay can produce…',['Up to 60° bank and 300 ft altitude loss','15° bank and 50 ft','30° bank and 100 ft','90° bank and 1000 ft'],0,'60° and 300 ft in climb/cruise/descent; 15° and 50 ft on approach with a 1-second delay.','159'],
['Supplements','Why might IFR GPS approaches be prohibited in a Travel Air?',['A throw-over yoke can block view of or access to the GNS/CDI','The Travel Air is not IFR certified','GPS approaches need dual GNS units','The autopilot cannot couple to GPS'],0,'IFR approaches are prohibited whenever an obstruction such as a throw-over yoke restricts view of or access to the GNS and/or CDI.','210'],
['Supplements','GNS without SBAS: predicted RAIM outage longer than ___ means delay, cancel or reroute.',['5 minutes','1 minute','15 minutes','34 minutes'],0,'More than 5 minutes of continuous RAIM loss on the route.','208'],
['Supplements','A required alternate must be planned using…',['LNAV minimums or a ground-based approach','LPV minimums','LNAV/VNAV minimums','Any RNAV minimums'],0,'Not acceptable to plan the alternate on LPV or LNAV/VNAV minimums.','209'],
['Supplements','GNS shows amber "DR". What does that mean?',['Dead reckoning; enroute/oceanic only, no CDI guidance','Loss of integrity; revert to other nav','Database expired','Approach downgraded to LNAV'],0,'DR estimates position from the last fix; not available in terminal or approach modes. INTEG is loss of integrity.','213'],
['Supplements','When may Pressure Altitude Broadcast Inhibit be used?',['Only when ATC requests it','Whenever above FL180','On the ground only','During formation flight at pilot discretion'],0,'PABI only when requested by ATC in ADS-B Out airspace.','146'],
];
const topics=['All',...new Set(Q.map(q=>q[0]))];
$('#qTopic').innerHTML=topics.map(t=>`<option>${t}</option>`).join('');
let mode='quiz', deck=[], idx=0, score=0, answered=false, missed=[];
function shuffle(a){a=a.slice();for(let i=a.length-1;i>0;i--){const j=Math.floor(Math.random()*(i+1));[a[i],a[j]]=[a[j],a[i]]}return a}
function build(){
  const t=$('#qTopic').value;
  deck=shuffle(Q.filter(q=>t==='All'||q[0]===t)).map(q=>{const order=shuffle([0,1,2,3]);return {topic:q[0],prompt:q[1],opts:order.map(i=>q[2][i]),correct:order.indexOf(q[3]),expl:q[4],src:q[5]}});
  idx=0;score=0;missed=[];answered=false;render();
}
function render(){
  const st=$('#qStage');
  $('#qProg').style.width=(deck.length?(idx/deck.length*100):0)+'%';
  if(idx>=deck.length){
    const pct=Math.round(score/deck.length*100);
    st.innerHTML=mode==='quiz'?`<div class="qcard result"><span class="eyebrow">Result</span><span class="g-big">${score}/${deck.length}</span><p>${pct}%. ${pct>=90?'Solid.':pct>=70?'Good. Review the misses below.':'Worth another pass through the Limitations and Emergencies tabs.'}</p>${missed.length?`<div><h4 style="margin-bottom:6px">Review</h4><ul class="plain">${missed.map(m=>`<li>${m.prompt} <b>${m.opts[m.correct]}</b> <span class="src">${m.src}</span></li>`).join('')}</ul></div>`:''}<div><button class="btn primary" id="again">Go again</button>${missed.length?` <button class="btn" id="retryMissed">Retry the ${missed.length} missed</button>`:''}</div></div>`
      :`<div class="qcard result"><span class="eyebrow">Deck complete</span><span class="g-big">${deck.length}</span><p>cards reviewed.</p><div><button class="btn primary" id="again">Shuffle again</button></div></div>`;
    $('#again').onclick=build;
    const rm=$('#retryMissed'); if(rm) rm.onclick=()=>{deck=shuffle(missed);idx=0;score=0;missed=[];render()};
    return;
  }
  const q=deck[idx];
  if(mode==='flash'){
    st.innerHTML=`<div class="flash" id="fc" tabindex="0" role="button" aria-label="Flip card"><div class="inner"><div class="face"><div class="qmeta"><span class="eyebrow">${q.topic} · ${idx+1} of ${deck.length}</span></div><div class="qprompt">${q.prompt}</div><span class="hint">Tap or press space to flip</span></div><div class="face back"><span class="eyebrow">Answer</span><div class="ans">${q.opts[q.correct]}</div><p>${q.expl}</p><span class="src">${q.src}</span></div></div></div><div class="qbar" style="margin-top:12px"><button class="btn" id="prev" ${idx===0?'disabled':''}>Previous</button><button class="btn primary" id="next">Next card</button></div>`;
    const fc=$('#fc');const flip=()=>fc.classList.toggle('flipped');fc.onclick=flip;fc.onkeydown=e=>{if(e.key===' '||e.key==='Enter'){e.preventDefault();flip()}};
    $('#next').onclick=()=>{idx++;render()}; $('#prev').onclick=()=>{if(idx>0){idx--;render()}};
    return;
  }
  answered=false;
  st.innerHTML=`<div class="qcard"><div class="qmeta"><span class="eyebrow">${q.topic} · ${idx+1} of ${deck.length}</span><span class="g-score">${score} correct</span></div><div class="qprompt">${q.prompt}</div><div class="g-opts">${q.opts.map((o,i)=>`<button class="g-opt" data-i="${i}"><span class="ltr">${'ABCD'[i]}</span><span>${o}</span></button>`).join('')}</div><div id="fb"></div></div>`;
  $$('.g-opt').forEach(b=>b.onclick=()=>{
    if(answered)return;answered=true;const i=+b.dataset.i,ok=i===q.correct;if(ok)score++;else missed.push(q);
    $$('.g-opt').forEach(x=>{x.disabled=true;const j=+x.dataset.i;if(j===q.correct)x.classList.add('right');else if(j===i)x.classList.add('wrong')});
    $('#fb').innerHTML=`<div class="expl"><b>${ok?'Correct.':'Not quite.'}</b> ${q.expl} <span class="src">${q.src}</span></div><div style="margin-top:12px"><button class="btn primary" id="next">${idx+1<deck.length?'Next question':'See result'}</button></div>`;
    $('.qmeta .g-score').textContent=score+' correct';
    $('#next').onclick=()=>{idx++;render()};$('#next').focus();
  });
}
function setMode(m){mode=m;$('#mQuiz').setAttribute('aria-pressed',m==='quiz');$('#mFlash').setAttribute('aria-pressed',m==='flash');build()}
$('#mQuiz').onclick=()=>setMode('quiz');$('#mFlash').onclick=()=>setMode('flash');
$('#qTopic').onchange=build;$('#qRestart').onclick=build;
build();
})();
