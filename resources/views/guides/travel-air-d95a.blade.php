@extends('layouts.app', ['title' => $guide['title'], 'heading' => $guide['heading'], 'meta' => $guide['meta'], 'wide' => true])

@push('head')
  @vite(['resources/css/guide.css', 'resources/js/guides/travel-air-d95a.js'])
@endpush

@section('content')
<div class="guide">
<div class="g-id">
  <span class="reg">Beech D95A Travel Air</span>
  <span class="meta">2 × LYCOMING IO-360-B1B · RAJAY TURBO 600</span>
</div>

<nav class="g-tabs" aria-label="Sections" role="tablist" id="tablist">
  <button role="tab" data-v="overview">Overview</button>
  <button role="tab" data-v="limits">Limitations</button>
  <button role="tab" data-v="speeds">Speeds</button>
  <button role="tab" data-v="systems">Systems</button>
  <button role="tab" data-v="normal">Checklists</button>
  <button role="tab" data-v="emerg">Emergencies</button>
  <button role="tab" data-v="perf">Performance</button>
  <button role="tab" data-v="supps">Supplements</button>
  <button role="tab" data-v="owner">Owner notes</button>
  <button role="tab" data-v="quiz">Quiz</button>
</nav>


<!-- ============ OVERVIEW ============ -->
<section class="view" id="v-overview">
  <div style="display:grid;gap:10px">
    <span class="eyebrow">Study guide · built from the aircraft's POH binder</span>
    <h2>Know the airplane before you fly it</h2>
    <p class="lede">Everything here comes from the aircraft's 221-page scanned POH binder: the 1964 Beech Owner's Manual, the FAA Airplane Flight Manual (Jan 1965), and the supplements for the equipment this airplane actually carries. Each fact has its PDF page number so you can check it against the source. The binder in the airplane is the authority. This page is for studying.</p>
  </div>

  <div class="g-note"><strong>Airspeed units.</strong> In this airplane's own AFM limitations page the mph values are struck out by hand and only the knots are left (PDF p.152), so the airspeed indicator is presumably in knots. This guide gives knots first and mph in grey. The Rajay and autopilot supplements are written in mph only, so those figures stay in mph.</div>

  <div class="grid3">
    <div class="vt" style="--stripe:var(--arc-red)"><span class="lbl">Never exceed (V<sub>NE</sub>)</span><span class="k">208<small>KCAS</small></span><span class="m">240 mph · p.152</span></div>
    <div class="vt" style="--stripe:var(--arc-red)"><span class="lbl">Min control (V<sub>MC</sub>)</span><span class="k">69.5<small>KCAS</small></span><span class="m">80 mph · p.153</span></div>
    <div class="vt" style="--stripe:var(--arc-blue)"><span class="lbl">Blue line (V<sub>YSE</sub>)</span><span class="k">94<small>KCAS</small></span><span class="m">108 mph · p.153</span></div>
    <div class="vt" style="--stripe:var(--accent)"><span class="lbl">Max gross weight</span><span class="k">4200<small>lb</small></span><span class="m">p.152</span></div>
  </div>

  <div class="grid2">
    <div class="card">
      <h3>The airplane</h3>
      <ul class="plain">
        <li>Two Lycoming IO-360-B1B, 180 hp at 2700 rpm, fuel-injected, 8.5:1 compression <span class="src">12</span></li>
        <li>Rajay Turbo 600 turbochargers with manual controls <span class="src">163</span></li>
        <li>Hartzell 2-blade constant-speed, full-feathering props, 70–72 in. <span class="src">152</span></li>
        <li>Electric gear and flaps, no downlocks (over-center linkage) <span class="src">11</span></li>
        <li>Edo-Aire Mitchell Century III autopilot AK425 with electric trim <span class="src">157</span></li>
        <li>Garmin GNS 5XXW GPS/SBAS navigator and Garmin GTX transponder with ADS-B Out <span class="src">199</span></li>
        <li>Normal category. Aerobatics and spins prohibited <span class="src">152</span></li>
      </ul>
    </div>
    <div class="card">
      <h3>How to use this</h3>
      <ul class="plain">
        <li><b>Limitations</b> and <b>Speeds</b> are the numbers you should know cold.</li>
        <li><b>Checklists</b> let you tick items off while you rehearse.</li>
        <li><b>Emergencies</b> separates memory items from read-and-do items.</li>
        <li><b>Supplements</b> covers what is different on this airplane: turbos, autopilot, avionics, fuel restrictions.</li>
        <li><b>Quiz</b> has a scored mode and a flashcard mode, filterable by topic.</li>
      </ul>
    </div>
  </div>

  <div style="display:grid;gap:10px">
    <h3>What's in the binder</h3>
    <div class="docmap">
      <div class="docrow"><span class="pp">p.1</span><div><h4>Owner's Manual supplement: usable fuel <span class="tag">Beech 1972</span></h4><p>Reduces usable fuel per main tank. Supersedes the Owner's Manual figures.</p></div></div>
      <div class="docrow"><span class="pp">p.2–127</span><div><h4>D95A Travel Air Owner's Manual <span class="tag">Beech 1964</span></h4><p>Sections I–VII: description, check lists, limitations, flying technique, emergencies, performance graphs, servicing.</p></div></div>
      <div class="docrow"><span class="pp">p.128–132</span><div><h4>Airplane Flight Manual + pilot's check list <span class="tag">FAA approved</span></h4><p>Generic copy of the AFM (limitations, procedures, performance) and the abbreviated check list card.</p></div></div>
      <div class="docrow"><span class="pp">p.133–150</span><div><h4>Garmin GTX 33X / 3X5 transponder AFMS <span class="tag">Rev 4, 2019</span></h4><p>ADS-B Out limitations and procedures.</p></div></div>
      <div class="docrow"><span class="pp">p.151–154</span><div><h4>This airplane's own AFM <span class="tag">FAA approved</span></h4><p>Cover page, then the AFM with mph struck out on the airspeed limits.</p></div></div>
      <div class="docrow"><span class="pp">p.155–156</span><div><h4>Beech AFM supplements <span class="tag">1965, 1968</span></h4><p>Emergency static source calibration; low-fuel turning-takeoff caution.</p></div></div>
      <div class="docrow"><span class="pp">p.157–159</span><div><h4>Century III autopilot AFMS <span class="tag">1973</span></h4><p>Autopilot limits, trim check, malfunction procedures.</p></div></div>
      <div class="docrow"><span class="pp">p.160–162</span><div><h4>Previous owner's notes and economy chart <span class="tag unoff">Unofficial</span></h4><p>Typed notes on autopilot, turbos, oil, quirks and speeds; a 1977 maximum-economy table.</p></div></div>
      <div class="docrow"><span class="pp">p.163–198</span><div><h4>Rajay turbocharger AFMS and Turbo 600 owner's manual <span class="tag">1967/68</span></h4><p>Turbo limits, placards, procedures, then schematics and parts lists.</p></div></div>
      <div class="docrow"><span class="pp">p.199–221</span><div><h4>Garmin GNS 5XXW GPS/SBAS AFMS <span class="tag">Rev G, 2020</span></h4><p>GPS limitations, RAIM planning, approaches, abnormal procedures.</p></div></div>
    </div>
  </div>
</section>

<!-- ============ LIMITATIONS ============ -->
<section class="view" id="v-limits" hidden>
  <div style="display:grid;gap:8px">
    <span class="eyebrow">AFM Section I · FAA approved · mandatory</span>
    <h2>Limitations</h2>
    <p class="lede">From the FAA-approved AFM dated January 8, 1965 (PDF p.152–153, this airplane's copy). Airspeed limits are calibrated airspeed.</p>
  </div>

  <div class="card">
    <div class="card-head"><h3>Airspeed indicator markings</h3><span class="src">152</span></div>
    <div class="asi-wrap">
      <svg class="asi" id="asi" viewBox="0 0 340 340" role="img" aria-label="Airspeed indicator in knots showing white arc 61 to 113, green arc 71 to 161, yellow arc 161 to 208, red line 208, blue line 94"></svg>
      <div class="g-legend">
        <div><span class="chip" style="background:var(--arc-white);border:1px solid var(--line)"></span><span><b>White arc 61–113 kt</b> <span class="mono" style="color:var(--muted)">(70–130 mph)</span><br>Flap operating range. Top = max flap extension speed.</span></div>
        <div><span class="chip" style="background:var(--arc-green)"></span><span><b>Green arc 71–161 kt</b> <span class="mono" style="color:var(--muted)">(81–185 mph)</span><br>Normal operating range. Top = design cruising speed.</span></div>
        <div><span class="chip" style="background:var(--arc-yellow)"></span><span><b>Yellow arc 161–208 kt</b> <span class="mono" style="color:var(--muted)">(185–240 mph)</span><br>Caution range. Smooth air only.</span></div>
        <div><span class="chip" style="background:var(--arc-red)"></span><span><b>Red radial 208 kt</b> <span class="mono" style="color:var(--muted)">(240 mph)</span><br>Never exceed.</span></div>
        <div><span class="chip" style="background:var(--arc-blue)"></span><span><b>Blue radial 94 kt</b> <span class="mono" style="color:var(--muted)">(108 mph)</span><br>Best single-engine rate of climb at sea level <span class="src">153</span></span></div>
        <p class="hint">Drawn from the AFM figures. Check the actual dial in the airplane; a converted indicator may be marked slightly differently.</p>
      </div>
    </div>
  </div>

  <div class="tbl"><table>
    <thead><tr><th>Airspeed limit (CAS)</th><th class="n">kt</th><th class="n">mph</th><th class="n">Source</th></tr></thead>
    <tbody>
      <tr><td>Never exceed, V<sub>NE</sub></td><td class="n">208</td><td class="n">240</td><td class="n src">152</td></tr>
      <tr><td>Design cruising / max structural cruising, V<sub>NO</sub></td><td class="n">161</td><td class="n">185</td><td class="n src">152</td></tr>
      <tr><td>Design maneuvering, V<sub>A</sub></td><td class="n">139</td><td class="n">160</td><td class="n src">152</td></tr>
      <tr><td>Max gear-down speed (normal), V<sub>LE</sub></td><td class="n">143</td><td class="n">165</td><td class="n src">152</td></tr>
      <tr><td>Max flap extension speed, V<sub>FE</sub></td><td class="n">113</td><td class="n">130</td><td class="n src">152</td></tr>
      <tr><td>Gear lowering, <i>extreme emergency only</i> (IAS). Inspect doors after.</td><td class="n">174</td><td class="n">200</td><td class="n src">72</td></tr>
      <tr><td>Pilot's storm window, do not open above (placard)</td><td class="n">—</td><td class="n">145</td><td class="n src">153</td></tr>
      <tr><td>Autopilot operation, max (CAS)</td><td class="n">—</td><td class="n">200</td><td class="n src">157</td></tr>
    </tbody></table></div>
  <p class="hint">Use controls with caution above 139 kt CAS and with extreme caution above 161 kt CAS (AFM note, p.152).</p>

  <div class="grid2">
    <div class="card">
      <div class="card-head"><h3>Engine limits</h3><span class="src">152, 163</span></div>
      <ul class="plain">
        <li><b>Naturally aspirated:</b> 2700 rpm and 29.0 in. MP (180 hp) for all operations.</li>
        <li><b>Turbocharged (Rajay):</b> takeoff 28.5 in. / 2700 rpm, 3 min; max continuous 28.0 in. / 2600 rpm to 20,000 ft; 25.0 in. / 2500 rpm from 20,000–25,000 ft. See Supplements.</li>
        <li><b>Fuel:</b> AFM says 91/96 minimum. <b>The Rajay STC raises this to 100/130 minimum</b> <span class="src">163</span>. Never 80/87 <span class="src">121</span>.</li>
        <li>Pitch at 30 in. station: low 14°, high 84° <span class="src">152</span></li>
      </ul>
    </div>
    <div class="card">
      <div class="card-head"><h3>Weight, CG, loads</h3><span class="src">152</span></div>
      <ul class="plain">
        <li>Max weight <b class="mono">4200 lb</b></li>
        <li>CG forward limit: <b class="mono">75.0 in.</b> aft of datum up to 3600 lb, straight line to <b class="mono">80.5 in.</b> at 4200 lb</li>
        <li>CG aft limit: <b class="mono">86.0 in.</b> at all weights (gear extended)</li>
        <li>Maneuver load factor at 4200 lb: <b class="mono">+4.4 G / −3.0 G</b></li>
        <li>Gust load factor: <b class="mono">+4.32 G / −2.32 G</b></li>
        <li>Baggage: 400 lb rear; 270 lb front less equipment <span class="src">6</span></li>
        <li>Bank angle in normal maneuvers not over 60°; no whip stalls <span class="src">51</span></li>
      </ul>
    </div>
  </div>

  <div class="tbl"><table>
    <thead><tr><th>Engine instrument</th><th>Red (min)</th><th>Yellow</th><th>Green</th><th>Red (max)</th><th class="n">Source</th></tr></thead>
    <tbody>
      <tr><td>Oil temperature</td><td>—</td><td class="mono">60–140 °F</td><td class="mono">140–245 °F</td><td class="mono">245 °F</td><td class="n src">152</td></tr>
      <tr><td>Oil pressure</td><td class="mono">25 psi (idle)</td><td>—</td><td class="mono">65–85 psi</td><td class="mono">85 psi</td><td class="n src">152</td></tr>
      <tr><td>Manifold pressure</td><td>—</td><td>—</td><td class="mono">14.5–29.0 in.</td><td class="mono">29.0 in.</td><td class="n src">152</td></tr>
      <tr><td>Cylinder head temp</td><td>—</td><td>—</td><td class="mono">200–500 °F</td><td class="mono">500 °F</td><td class="n src">152</td></tr>
      <tr><td>Tachometer</td><td>—</td><td>—</td><td class="mono">2000–2700 rpm</td><td class="mono">2700 rpm</td><td class="n src">152</td></tr>
      <tr><td>Fuel flow</td><td>—</td><td>—</td><td class="mono">0–17.8 gph</td><td class="mono">10.0 psi</td><td class="n src">152</td></tr>
      <tr><td>Suction</td><td class="mono">3.75 in.</td><td class="mono">3.75–4.8 in.<div class="sub">check pumps</div></td><td class="mono">4.8–5.25 in.</td><td class="mono">5.25 in.</td><td class="n src">41, 152</td></tr>
    </tbody></table></div>
  <div class="g-note"><strong>Two small conflicts in the binder.</strong> The Owner's Manual gives the fuel-flow green arc as 0–17.0 gph (p.40); the FAA-approved AFM says 0–17.8 gph (p.152). The AFM also gives a single 3.75–5.25 in. suction green arc, while the Owner's Manual splits it with a yellow "check pumps" band from 3.75–4.8 (p.41). Where they differ, the AFM is the approved document.</div>

  <div class="card">
    <div class="card-head"><h3>Placards to recognize</h3><span class="src">152–153, 155, 163</span></div>
    <ul class="plain">
      <li>"Use aux tanks and crossfeed in level flight only." (between fuel selectors)</li>
      <li>"Emergency landing gear: engage handle in rear of front seat and turn counterclockwise as far as possible (50 turns)."</li>
      <li>"Caution. Do not open above 145 MPH." (pilot's storm window)</li>
      <li>"Latch window before take-off. Do not open in flight." (middle windows, if openable)</li>
      <li>Emergency static source warning: see Flight Manual for airspeed/altimeter calibration error.</li>
      <li>Rajay: fuel boost pumps ON above 8,000 ft MSL; emergency descent 185 mph IAS; wide-open throttle before engaging turbos; manual leaning at altitude; reduce V<sub>NE</sub> 6 mph (5 kt) per 1000 ft above 20,000 ft; not evaluated above 25,000 ft.</li>
      <li>Autopilot: "Conduct trim check prior to flight (See AFM)." <span class="src">157</span></li>
    </ul>
  </div>
</section>

<!-- ============ SPEEDS ============ -->
<section class="view" id="v-speeds" hidden>
  <div style="display:grid;gap:8px">
    <span class="eyebrow">Owner's Manual 3-2, 3-3 · AFM procedures</span>
    <h2>Operating speeds</h2>
    <p class="lede">Owner's Manual speeds are indicated airspeed at 4200 lb (p.38–39). AFM speeds are calibrated (p.153–154). Knots as printed in the manual.</p>
  </div>

  <div class="vtiles">
    <div class="vt" style="--stripe:var(--arc-red)"><span class="lbl">V<sub>MC</sub></span><span class="k">69.5<small>kt</small></span><span class="m">80 mph CAS</span></div>
    <div class="vt" style="--stripe:var(--accent)"><span class="lbl">V<sub>XSE</sub> (SL)</span><span class="k">85<small>kt</small></span><span class="m">98 mph IAS</span></div>
    <div class="vt" style="--stripe:var(--arc-blue)"><span class="lbl">V<sub>YSE</sub> (SL)</span><span class="k">94<small>kt</small></span><span class="m">108 mph</span></div>
    <div class="vt" style="--stripe:var(--accent)"><span class="lbl">V<sub>Y</sub> two-engine (SL)</span><span class="k">95.5<small>kt</small></span><span class="m">110 mph CAS</span></div>
    <div class="vt" style="--stripe:var(--accent)"><span class="lbl">Normal liftoff</span><span class="k">74<small>kt</small></span><span class="m">85 mph</span></div>
    <div class="vt" style="--stripe:var(--accent)"><span class="lbl">Normal approach</span><span class="k">79<small>kt</small></span><span class="m">91 mph</span></div>
    <div class="vt" style="--stripe:var(--accent)"><span class="lbl">Cruise climb</span><span class="k">121.5<small>kt</small></span><span class="m">140 mph · 25 in./2450</span></div>
    <div class="vt" style="--stripe:var(--accent)"><span class="lbl">Best glide</span><span class="k">~104<small>kt</small></span><span class="m">120 mph · 13.6:1</span></div>
  </div>
  <p class="hint">Best glide is 120 mph IAS in the glide table (p.41); 104 kt is a conversion, not a printed figure.</p>

  <div class="grid2">
    <div class="tbl"><table>
      <thead><tr><th>Takeoff &amp; landing (IAS)</th><th class="n">kt</th><th class="n">mph</th></tr></thead>
      <tbody>
        <tr><td>Normal takeoff (0° flaps)</td><td class="n">74</td><td class="n">85</td></tr>
        <tr><td>Normal climb-out at 50 ft</td><td class="n">87</td><td class="n">100</td></tr>
        <tr><td>Short-field takeoff (20° flaps)</td><td class="n">61</td><td class="n">70</td></tr>
        <tr><td>Short-field climb-out</td><td class="n">78</td><td class="n">90</td></tr>
        <tr><td>Normal approach</td><td class="n">79</td><td class="n">91</td></tr>
        <tr><td>Short-field approach</td><td class="n">74</td><td class="n">85</td></tr>
        <tr><td>Contact (both)</td><td class="n">65</td><td class="n">75</td></tr>
        <tr><td>Balked landing climb, gear &amp; flaps down (CAS)</td><td class="n">70.5</td><td class="n">81.5</td></tr>
      </tbody></table></div>
    <div class="tbl"><table>
      <thead><tr><th>Climb (IAS, 5,000 ft)</th><th class="n">kt</th><th class="n">mph</th></tr></thead>
      <tbody>
        <tr><td>V<sub>Y</sub> gear &amp; flaps up</td><td class="n">89.5</td><td class="n">103</td></tr>
        <tr><td>V<sub>Y</sub> gear down</td><td class="n">72</td><td class="n">83</td></tr>
        <tr><td>V<sub>Y</sub> gear &amp; flaps down</td><td class="n">68.5</td><td class="n">79</td></tr>
        <tr><td>V<sub>X</sub> gear &amp; flaps up</td><td class="n">72</td><td class="n">83</td></tr>
        <tr><td>V<sub>X</sub> gear down / gear &amp; flaps down</td><td class="n">60</td><td class="n">69</td></tr>
        <tr><td>SE best rate, SL (gear/flaps up)</td><td class="n">94</td><td class="n">108</td></tr>
        <tr><td>SE best angle, SL (gear/flaps up)</td><td class="n">85</td><td class="n">98</td></tr>
        <tr><td>SE minimum control</td><td class="n">69.5</td><td class="n">80</td></tr>
      </tbody></table></div>
  </div>
  <p class="hint">Source p.38–39. AFM V<sub>Y</sub> reduces 1 mph per 2,000 ft; V<sub>YSE</sub> reduces 1 mph per 1,000 ft (p.154).</p>

  <div class="card">
    <div class="card-head"><h3>Stall speeds, 4200 lb (IAS)</h3><span class="src">39</span></div>
    <div class="tbl" style="border:0"><table>
      <thead><tr><th>Configuration</th><th>Power</th><th class="n">Level</th><th class="n">15°</th><th class="n">30°</th><th class="n">45°</th></tr></thead>
      <tbody>
        <tr><td rowspan="2">Gear &amp; flaps up</td><td>On*</td><td class="n">53.0</td><td class="n">54.0</td><td class="n">57.0</td><td class="n">63.0</td></tr>
        <tr><td>Off</td><td class="n">73.5</td><td class="n">75.0</td><td class="n">79.5</td><td class="n">87.5</td></tr>
        <tr><td rowspan="2">Gear &amp; flaps down 28°</td><td>On*</td><td class="n">43.5</td><td class="n">44.0</td><td class="n">46.5</td><td class="n">51.5</td></tr>
        <tr><td>Off</td><td class="n">65.0</td><td class="n">66.5</td><td class="n">70.0</td><td class="n">77.5</td></tr>
      </tbody></table></div>
    <p class="hint">Knots IAS. *Power on = 25.0 in. Hg and 2700 rpm. The AFM's zero-thrust stall speeds (CAS) are 70.0 kt clean and 61.0 kt dirty at wings level; max altitude lost in a stall about 300 ft (p.154). Stall horn sounds 5–10 mph above the stall (p.153).</p>
  </div>
</section>

<!-- ============ SYSTEMS ============ -->
<section class="view" id="v-systems" hidden>
  <div style="display:grid;gap:8px">
    <span class="eyebrow">Owner's Manual Section I</span>
    <h2>Systems</h2>
  </div>

  <div class="card">
    <div class="card-head"><h3>Fuel</h3><span class="src">1, 14, 16, 49, 153, 156</span></div>
    <div class="tbl"><table>
      <thead><tr><th>Arrangement</th><th>Cells per wing</th><th class="n">Usable per 1972 supplement</th></tr></thead>
      <tbody>
        <tr><td>Standard</td><td>One 40-gal main</td><td class="n">37 gal per main</td></tr>
        <tr><td>Optional (112 gal)</td><td>25-gal main + 31-gal aux</td><td class="n">22 gal per main</td></tr>
      </tbody></table></div>
    <p class="hint">The 1972 supplement (p.1) supersedes the Owner's Manual's 80 / 112 gal usable figures. It changes the main tanks only, so by arithmetic the totals become about 74 gal (standard) or 106 gal (optional). Confirm which arrangement the airplane has; the owner's notes mention switching tanks and aux use.</p>
    <ul class="plain">
      <li>Each engine has its own identical system. Suction crossfeed lines connect them for emergency use. Fuel cannot transfer between cells.</li>
      <li><b>Take off and land on the main tanks only, without crossfeed.</b> Aux tanks and crossfeed in level flight only.</li>
      <li>If both engines are running and one selector is on crossfeed, <b>both engines feed from the tank selected by the other valve</b>. An interlock stops both selectors going to crossfeed at once.</li>
      <li>Electric aux pumps (in line, between cells and the metering unit): for starting and emergencies; may be used for takeoff and landing; in extremely hot weather use them for all ground ops, takeoff, climb and landing.</li>
      <li>8 drain points: wheel-well strainers, two fuselage low spots, cell sumps (incl. aux sumps).</li>
      <li>Fuel-flow gauge reads gph from pressure at the fuel manifold valve; it also shows fuel pressure for starting.</li>
      <li><b>Low-fuel caution (1968 AFMS):</b> no turning takeoff, or takeoff right after a fast taxi turn, if a 25-gal main holds under 5 gal or a 40-gal main holds under 25 gal. Avoid long slips or skids when fuel is low <span class="src">156</span></li>
    </ul>
  </div>

  <div class="grid2">
    <div class="card">
      <div class="card-head"><h3>Landing gear &amp; brakes</h3><span class="src">10–12, 73</span></div>
      <ul class="plain">
        <li>Electric motor and gearbox under the front seat. Two-position switch must be pulled out of a detent to move.</li>
        <li><b>No downlocks.</b> The over-center linkage is a geometric lock, spring-loaded over center. Main gear has uplocks.</li>
        <li>Safety switch on the <b>left main strut</b> opens the circuit on the ground. Never rely on it; always check the handle.</li>
        <li>Gear horn: intermittent, gear up with either throttle retarded. Single-engine: crack the dead engine's throttle to silence.</li>
        <li>Lights only at full up or full down; mechanical nose-gear indicator below the console.</li>
        <li>Handcrank behind front seats lowers only, about 50 turns counterclockwise.</li>
        <li>Parking brake closes a valve to hold pumped pressure; it does not pressurize the system.</li>
        <li>Strut extension: 3 in. main, 3½ in. nose. Tires 50 psi main and nose <span class="src">106, 113</span></li>
      </ul>
    </div>
    <div class="card">
      <div class="card-head"><h3>Propellers</h3><span class="src">13, 45–46</span></div>
      <ul class="plain">
        <li>Feathering spring and blade counterweights drive pitch <b>up</b> (toward feather). Governor-boosted oil drives pitch <b>down</b>. Lose the oil pressure and the prop feathers.</li>
        <li>Feather: pull the prop lever back past the detent to the stop.</li>
        <li>When exercising props, do not go past the detent; the blade goes to feather quickly and stresses the shank and engine.</li>
        <li>Unfeather: lever well into the governing range, normal start. With the optional accumulator, the starter is only needed at low airspeed.</li>
        <li>After restart, adjust throttle and prop at once to prevent overspeed.</li>
      </ul>
    </div>
    <div class="card">
      <div class="card-head"><h3>Flaps &amp; controls</h3><span class="src">10, 120</span></div>
      <ul class="plain">
        <li>Single slotted flaps, electric, jackscrew actuators. Positions marked 10°, 20°, 28° on the left flap leading edge.</li>
        <li>Three-position switch; select OFF when the desired mark lines up with the trailing edge. Green light = up, red = full down.</li>
        <li>AFM flap settings: takeoff 0°, landing 28° <span class="src">153</span>. Short-field takeoff uses 20°.</li>
        <li>Throw-over control wheel; can be locked pilot or copilot side.</li>
        <li>Aileron trim displaces the ailerons themselves via the column hub trimmer.</li>
      </ul>
    </div>
    <div class="card">
      <div class="card-head"><h3>Electrical</h3><span class="src">18–19, 101</span></div>
      <ul class="plain">
        <li>24-volt, negative ground, single-wire ground return.</li>
        <li>Generator option: two 25-A generators, paralleling relay. Alternator option: two 50-A alternators, one transistorized regulator active (select 1 or 2), overvoltage relay and press-to-test light.</li>
        <li>Overvoltage light on: switch regulators; if it persists, pull the 5-A alternator field breaker and minimize load.</li>
        <li>Max 45 A per alternator on the ground above 100 °F or above 14,000 ft with OAT above 45 °F (as printed).</li>
        <li>Ammeters are load meters, not charge/discharge.</li>
        <li>Alternator switches OFF before connecting external power. External power must be negative-ground, 27–28.5 V.</li>
      </ul>
    </div>
    <div class="card">
      <div class="card-head"><h3>Oil &amp; engines</h3><span class="src">12, 16, 103, 120</span></div>
      <ul class="plain">
        <li>Wet sump, 8 qt per engine; absolute minimum 2 qt. (Previous owner: don't fill above 7, the left engine throws out the 8th.)</li>
        <li>Thermostatic bypass around the oil cooler.</li>
        <li>Oil change every 50 hr normally.</li>
        <li>Alternate air: spring door opens automatically if the scoop ices; manual control on console. Fuel injection means impact ice is the only induction-icing concern.</li>
        <li>Cranking limit 10–12 s, 5-min cool-down. No oil pressure within 30 s: shut down.</li>
      </ul>
    </div>
    <div class="card">
      <div class="card-head"><h3>Vacuum, heater, pitot-static</h3><span class="src">22–24, 57, 155</span></div>
      <ul class="plain">
        <li>Two engine-driven vacuum pumps, one system; either can run all gyros. Check valves close if a pump fails.</li>
        <li>Combustion heater, 50,000 BTU, burns fuel from the <b>left main tank</b>. Overheat switch at 300 °F blows a fuse that is deliberately out of reach in flight.</li>
        <li>Blower runs only with gear down.</li>
        <li>Emergency static (on deice-equipped airplanes): valve OPEN with storm window closed. Airspeed and altimeter generally read high; correction tables on p.155.</li>
      </ul>
    </div>
  </div>
</section>

<!-- ============ CHECKLISTS ============ -->
<section class="view" id="v-normal" hidden>
  <div style="display:grid;gap:8px">
    <span class="eyebrow">Pilot's Check List P/N 95-590014-63 · Owner's Manual Section II</span>
    <h2>Normal checklists</h2>
    <p class="lede">From the abbreviated pilot's check list (p.131–132), with the turbo items from the Rajay AFMS (p.164–165) added where they belong and marked. Tick items as you rehearse.</p>
  </div>
  <div class="cl-tools"><button class="btn sm" id="clReset">Clear all ticks</button><span class="hint">Never taxi with a flat strut.</span></div>
  <div class="grid2" id="checklists"></div>
</section>

<!-- ============ EMERGENCIES ============ -->
<section class="view" id="v-emerg" hidden>
  <div style="display:grid;gap:8px">
    <span class="eyebrow">Owner's Manual Section V · AFM emergency procedures</span>
    <h2>Emergencies</h2>
    <p class="lede">"The best time to know procedures and the worst time to practice them is during an emergency." (p.61)</p>
  </div>

  <div class="card">
    <div class="card-head"><span class="boxhead red">Engine failure · identify</span><span class="src">64</span></div>
    <ol class="memory">
      <li><span><b>Fly the airplane.</b> All six levers full forward.</span></li>
      <li><span><b>Dead foot, dead engine.</b> Rudder pressure is on the good engine's side.</span></li>
      <li><span>CHT drops on the failed engine.</span></li>
      <li><span><b>Verify:</b> partially retard the suspect throttle. No change in sound or control pressure means it's the right one. Use extreme caution at low altitude and airspeed.</span></li>
    </ol>
    <div class="danger">Never identify the dead engine by tachometer or manifold pressure. A windmilling engine can show normal rpm, and MP will read near atmospheric.</div>
  </div>

  <div class="card">
    <div class="card-head"><span class="boxhead red">Engine failure on takeoff</span><span class="src">66–67</span></div>
    <div class="grid3">
      <div><h4>A · Runway remains</h4><p>Cut power immediately and stop straight ahead.</p></div>
      <div><h4>B · No runway, below V<sub>XSE</sub></h4><p>Throttles closed. Battery and generator switches OFF. Fuel selectors OFF. Continue straight ahead, turning only to avoid obstacles.</p></div>
      <div><h4>C · Airborne, at or above V<sub>XSE</sub></h4><p>Clean up at once (gear up, feather the windmilling prop), then the normal single-engine procedure. Obstacles: hold V<sub>XSE</sub>. No obstacles: accelerate to V<sub>YSE</sub>. Return to land.</p></div>
    </div>
    <p class="hint">With gear down, prop windmilling and cowl flaps open, altitude cannot be maintained. Check the accelerate-stop graph (p.92) before each takeoff.</p>
  </div>

  <div class="card">
    <div class="card-head"><span class="boxhead red">Single-engine procedure</span><span class="src">65, 132</span></div>
    <ol class="memory">
      <li><span>Throttles, props, mixtures (both): <b>full forward</b>. Rudder for control; bank about 5° toward the good engine (into the heavy rudder).</span></li>
      <li><span>Landing gear: <b>up</b>. Flaps up gradually if extended.</span></li>
      <li><span>Dead engine: prop <b>feather</b>, mixture <b>idle cut-off</b>.</span></li>
      <li><span>Dead engine cowl flap: <b>closed</b>.</span></li>
      <li><span>As the prop stops: generator/alternator and ignition <b>off</b>. If it won't stop, slow down slightly.</span></li>
      <li><span>Dead engine fuel selector: <b>off</b>.</span></li>
      <li><span>Unneeded electrical equipment: <b>off</b>.</span></li>
      <li><span>Airspeed <b>94 kt (108 mph)</b> if a climb is needed. Takeoff power until safe altitude, then cruise power for hands-off trim.</span></li>
      <li><span>Rudder trim set; trim the dead-engine wing 3–5° high.</span></li>
      <li><span><b>Land as soon as practicable.</b></span></li>
    </ol>
    <p class="hint">Before feathering, if altitude allows: check fuel flow (aux pump on), fuel quantity (switch tanks), oil pressure and temperature, ignition switch (p.67).</p>
  </div>

  <div class="grid2">
    <div class="card">
      <div class="card-head"><span class="boxhead amb">Restart in flight</span><span class="src">68</span></div>
      <ol class="memory">
        <li><span>Find and fix the cause first. Continuing on one engine beats ruining a repairable one.</span></li>
        <li><span>Fuel selector MAIN or AUX; throttle to start position.</span></li>
        <li><span>Prop lever well into the governing range.</span></li>
        <li><span>No accumulator: aux pump on, fuel flow shows, engage starter.</span></li>
        <li><span>After a few revolutions, mixture full rich.</span></li>
        <li><span>If it won't run: aux pump off, mixture idle cut-off to clear.</span></li>
        <li><span>On start: throttle and prop to prevent overspeed. Check fuel flow and oil pressure; if abnormal, refeather.</span></li>
        <li><span>Warm up at about <b>2000 rpm and 15 in.</b> Oil pressure normal within 30 s or shut down.</span></li>
        <li><span>When oil temp is normal: rpm first, then throttle. Retrim.</span></li>
      </ol>
      <p class="hint">In cold weather restart within a few minutes; cold oil can stop the prop unfeathering.</p>
    </div>
    <div class="card">
      <div class="card-head"><span class="boxhead amb">Single-engine landing &amp; go-around</span><span class="src">68–69</span></div>
      <ul class="plain">
        <li>Higher, wider pattern; more airspeed; no steep turns.</li>
        <li>Gear down only once final is established. Aim to overshoot, not undershoot.</li>
        <li>Flaps only after the gear is down and the field is made.</li>
        <li>Reduce rudder trim toward neutral as power comes off.</li>
        <li><b>With full flaps and gear down, level flight is not possible at gross weight on one engine.</b> Don't go around unless there is time to clean up.</li>
      </ul>
      <h4>Go-around (only to avoid an accident)</h4>
      <ol class="memory">
        <li><span>Full power, correct for yaw, hold V<sub>YSE</sub>.</span></li>
        <li><span>Gear up; dead engine cowl flap closed.</span></li>
        <li><span>Full flaps: retract to about half.</span></li>
        <li><span>Remaining flaps up as soon as practicable.</span></li>
        <li><span>Trim for single-engine climb.</span></li>
      </ol>
    </div>
    <div class="card">
      <div class="card-head"><span class="boxhead red">Engine fire in flight</span><span class="src">73</span></div>
      <ol class="memory">
        <li><span>Fuel selector: <b>OFF</b></span></li>
        <li><span>Mixture: <b>IDLE CUT-OFF</b></span></li>
        <li><span>Prop: <b>FEATHER</b></span></li>
        <li><span>Boost pump: <b>OFF</b></span></li>
        <li><span>Ignition: <b>OFF</b></span></li>
        <li><span>Generator: <b>OFF</b></span></li>
      </ol>
      <p>Then the single-engine procedure. <b>Land immediately.</b></p>
    </div>
    <div class="card">
      <div class="card-head"><span class="boxhead amb">Manual gear extension</span><span class="src">73, 153</span></div>
      <ol class="memory">
        <li><span>Slow down first if you can.</span></li>
        <li><span>Landing gear circuit breaker: <b>pulled</b>.</span></li>
        <li><span>Gear switch: <b>DOWN</b>.</span></li>
        <li><span>Remove the boot from the crank behind the front seats; turn <b>counterclockwise</b> as far as possible (about 50 turns).</span></li>
        <li><span>Check the mechanical indicator (and lights/horn if there's power).</span></li>
      </ol>
      <p class="hint">The crank cannot retract the gear. Keep the handle stowed and disengaged when not in use.</p>
    </div>
    <div class="card">
      <div class="card-head"><span class="boxhead amb">Gear-up landing</span><span class="src">72</span></div>
      <ul class="plain">
        <li>Normal approach, hard surface if possible (sod rolls into chunks). Flaps as needed.</li>
        <li>When the runway is made: throttles closed, mixtures idle cut-off, battery master and all ignition off, fuel selectors off.</li>
        <li>Wings level, touch down as gently as possible.</li>
      </ul>
    </div>
    <div class="card">
      <div class="card-head"><span class="boxhead blu">Other situations</span><span class="src">47, 52, 72–73, 41</span></div>
      <ul class="plain">
        <li><b>Door opens on takeoff:</b> it trails 3–4 in. open and doesn't affect handling. Ignore it and return normally.</li>
        <li><b>Balked landing:</b> takeoff power, climb attitude, gear up when solidly airborne, flaps up but not quickly near the ground, climb at V<sub>Y</sub>.</li>
        <li><b>Severe turbulence:</b> gear may be lowered up to 174 kt (200 mph) IAS as an emergency measure, in level flight. Don't use flaps. Switch to mains. Inspect gear doors afterward.</li>
        <li><b>Max glide:</b> both props feathered, gear, flaps and cowl flaps up. About 13.6:1 at 120 mph IAS, roughly 2.5 statute miles per 1000 ft.</li>
        <li><b>Inadvertent spin:</b> power off both, full opposite rudder, elevator forward until rotation stops, recover smoothly.</li>
        <li><b>Inadvertent IMC (VFR pilot):</b> the 180° turn: gear down (emergency up to 174 kt), slow, trim, rudder-only turn hands off <span class="src">59</span></li>
      </ul>
    </div>
  </div>
</section>

<!-- ============ PERFORMANCE ============ -->
<section class="view" id="v-perf" hidden>
  <div style="display:grid;gap:8px">
    <span class="eyebrow">AFM Section III · FAA flight test data · 4200 lb, no wind, level paved runway</span>
    <h2>Performance</h2>
    <p class="lede">Tabulated AFM data (p.154). Rows are pressure altitude, columns are outside air temperature. Pick a row and column to highlight it. Airspeeds here are mph CAS as printed.</p>
  </div>
  <div class="qbar">
    <label for="pAlt" class="eyebrow">Altitude</label>
    <select id="pAlt"><option value="0">Sea level</option><option value="1">2,000 ft</option><option value="2">4,000 ft</option><option value="3">6,000 ft</option><option value="4">8,000 ft</option></select>
    <label for="pOat" class="eyebrow">OAT</label>
    <select id="pOat"><option value="0">0 °F</option><option value="1">25 °F</option><option value="2" selected>50 °F</option><option value="3">75 °F</option><option value="4">100 °F</option></select>
  </div>
  <div class="grid3" id="perfTiles"></div>
  <div class="grid2" id="perfTables"></div>
  <div class="g-note"><strong>Single-engine ceiling is low.</strong> At 4200 lb on a 100 °F day the airplane climbs 2 fpm on one engine at 4,000 ft and is sinking by 6,000 ft. At 75 °F it can't hold 6,000 ft either. Book service ceiling on one engine is 4,400 ft at standard conditions (p.6). The Rajay supplement says turbocharged performance is "as good as or better than" these figures (p.166), but use the book numbers for planning.</div>

  <div class="card">
    <div class="card-head"><h3>Glide distance (statute miles, props feathered, clean)</h3><span class="src">41</span></div>
    <div class="tbl" style="border:0"><table>
      <thead><tr><th>Height AGL</th><th class="n">30 tail<div class="sub">111</div></th><th class="n">20 tail<div class="sub">113</div></th><th class="n">10 tail<div class="sub">116</div></th><th class="n">Calm<div class="sub">120</div></th><th class="n">10 head<div class="sub">123</div></th><th class="n">20 head<div class="sub">126</div></th><th class="n">30 head<div class="sub">130</div></th></tr></thead>
      <tbody>
        <tr><td class="mono">2,000 ft</td><td class="n">6.6</td><td class="n">6.1</td><td class="n">5.6</td><td class="n"><b>5.2</b></td><td class="n">4.7</td><td class="n">4.3</td><td class="n">3.9</td></tr>
        <tr><td class="mono">4,000 ft</td><td class="n">13.1</td><td class="n">12.1</td><td class="n">11.2</td><td class="n"><b>10.3</b></td><td class="n">9.5</td><td class="n">8.6</td><td class="n">7.8</td></tr>
        <tr><td class="mono">6,000 ft</td><td class="n">19.7</td><td class="n">18.2</td><td class="n">16.8</td><td class="n"><b>15.5</b></td><td class="n">14.2</td><td class="n">13.0</td><td class="n">11.7</td></tr>
        <tr><td class="mono">8,000 ft</td><td class="n">26.2</td><td class="n">24.2</td><td class="n">22.4</td><td class="n"><b>20.6</b></td><td class="n">18.9</td><td class="n">17.3</td><td class="n">15.6</td></tr>
        <tr><td>Glide ratio</td><td class="n">17.3</td><td class="n">16.0</td><td class="n">14.8</td><td class="n"><b>13.6</b></td><td class="n">12.5</td><td class="n">11.4</td><td class="n">10.3</td></tr>
      </tbody></table></div>
    <p class="hint">Wind in mph; small numbers are the IAS (mph) to fly. Add speed into a headwind, subtract with a tailwind.</p>
  </div>

  <div class="card">
    <div class="card-head"><h3>Book figures (Owner's Manual specifications)</h3><span class="src">6</span></div>
    <div class="grid3">
      <div><span class="eyebrow">Max cruise 75%</span><p class="mono">174 kt TAS at 7,500 ft</p></div>
      <div><span class="eyebrow">Cruise 65%</span><p class="mono">169 kt TAS at 11,000 ft</p></div>
      <div><span class="eyebrow">Rate of climb SL</span><p class="mono">1250 fpm · 205 fpm SE</p></div>
      <div><span class="eyebrow">Service ceiling</span><p class="mono">18,100 ft · 4,400 ft SE</p></div>
      <div><span class="eyebrow">SE absolute ceiling</span><p class="mono">5,850 ft</p></div>
      <div><span class="eyebrow">Range</span><p class="mono">1170 mi on 112 gal</p></div>
    </div>
    <p class="hint">The 1972 fuel supplement cuts range by 7–10% for the reduced usable fuel (p.1).</p>
  </div>
</section>

<!-- ============ SUPPLEMENTS ============ -->
<section class="view" id="v-supps" hidden>
  <div style="display:grid;gap:8px">
    <span class="eyebrow">What's different on this airplane</span>
    <h2>Supplements</h2>
    <p class="lede">Each supplement overrides the basic AFM only where it says so.</p>
  </div>

  <div class="card">
    <div class="card-head"><h3>Rajay turbochargers (manual controls)</h3><span class="src">163–166</span></div>
    <div class="tbl"><table>
      <thead><tr><th>Rating</th><th class="n">MP (in.)</th><th class="n">rpm</th><th class="n">Altitude (ft)</th><th class="n">Time</th></tr></thead>
      <tbody>
        <tr><td>Takeoff</td><td class="n">28.5</td><td class="n">2700</td><td class="n">3,500–12,000</td><td class="n">3 min</td></tr>
        <tr><td>Max continuous</td><td class="n">28.0</td><td class="n">2600</td><td class="n">3,500–20,000</td><td class="n">No limit</td></tr>
        <tr><td>Max continuous</td><td class="n">25.0</td><td class="n">2500</td><td class="n">20,000–25,000</td><td class="n">No limit</td></tr>
      </tbody></table></div>
    <div class="grid2">
      <div style="display:grid;gap:8px">
        <h4>Limits &amp; placards</h4>
        <ul class="plain">
          <li>Fuel: <b>100/130 minimum</b></li>
          <li>Fuel boost pumps ON above 8,000 ft MSL</li>
          <li>Wide-open throttle before engaging the turbochargers</li>
          <li>Manual leaning required at altitude during power reduction</li>
          <li>Reduce V<sub>NE</sub> 6 mph (5 kt) per 1000 ft above 20,000 ft</li>
          <li>Emergency descent: idle, gear and flaps up, 185 mph IAS</li>
          <li>Not FAA-evaluated above 25,000 ft</li>
          <li>Minimum turbocharged climb speed: <b>120 mph IAS</b> two engines, <b>110 mph IAS</b> one engine</li>
        </ul>
      </div>
      <div style="display:grid;gap:8px">
        <h4>Procedures</h4>
        <ul class="plain">
          <li><b>Before start:</b> turbo controls OFF; turbo oil lights ON with master on.</li>
          <li><b>Run-up:</b> lights OFF (they may be on at idle). At 2200 rpm push the control toward ON until MP rises, max 28.5 in., then OFF. Each engine.</li>
          <li><b>Normal takeoff and landing:</b> turbos OFF.</li>
          <li><b>High-altitude takeoff:</b> after run-up, at full throttle set turbos for 26.5 in. static (don't exceed); ram recovery brings 28.0–28.5 in. on the roll. Mixture full rich. Reduce to max continuous within 3 min.</li>
          <li><b>Descent:</b> reduce with the turbo controls until fully out, leaning to match. Fully out = normally aspirated.</li>
          <li><b>High-altitude landing:</b> turbos may be preset for 28.5 in./2700 for a go-around, throttles retarded, mixture leaned on approach.</li>
          <li><b>After a turbocharged (high-altitude) landing:</b> turbos OFF at once and <b>wait at least 2 minutes before shutdown</b> so the turbines spin down while still lubricated.</li>
        </ul>
      </div>
    </div>
    <div class="grid2">
      <div class="danger"><b>Turbo boost failure:</b> power loss on that engine. Pull its turbo control OFF, lean as needed, continue on normal power.</div>
      <div class="danger"><b>Turbo oil pressure light ON:</b> the turbo isn't getting enough oil. Pull its control OFF, continue on normal power, watch engine oil pressure and temperature.</div>
    </div>
  </div>

  <div class="card">
    <div class="card-head"><h3>Century III autopilot &amp; electric trim</h3><span class="src">157–159</span></div>
    <div class="grid2">
      <ul class="plain">
        <li>Max autopilot speed <b>200 mph CAS</b>.</li>
        <li>Autopilot <b>OFF for takeoff and landing</b>.</li>
        <li><b>Single-engine missed approaches not authorized.</b></li>
        <li>Trim check before every flight (placarded). If any part fails, pull the trim breaker and leave it out.</li>
        <li>Altitude hold: reduce climb/descent to 500 fpm before engaging. Below about 120 mph CAS, lower 50% flaps.</li>
        <li>Approaches: initial/intermediate at 50% flaps, 110–130 mph CAS. At glidepath intercept or FAF, gear down and about 120 mph CAS.</li>
      </ul>
      <ul class="plain">
        <li><b>Disconnect:</b> emergency disconnect/interrupt switch, trim "AP OFF" bar, roll rocker OFF, or overpower.</li>
        <li><b>Trim runaway:</b> hold the interrupt switch; trim master OFF; retrim manually; release (watch for trim action); pull the trim breaker.</li>
        <li><b>Malfunction effects:</b> in cruise a 3-second recognition delay can mean 60° of bank and 300 ft lost (worst at 200 mph descending). On approach a 1-second delay: 15° and 50 ft.</li>
        <li><b>Engine failure:</b> cruise, retrim and do normal procedures. On final, disconnect and hand-fly. Before the initial segment, retrim and continue.</li>
      </ul>
    </div>
  </div>

  <div class="grid2">
    <div class="card">
      <div class="card-head"><h3>Garmin GNS 5XXW GPS/SBAS</h3><span class="src">206–215</span></div>
      <ul class="plain">
        <li>Quick Reference Guide must be immediately available when navigating with the unit.</li>
        <li>IFR GPS navigation and approaches need a current database; approaches must be loaded by name. Manually entered waypoints on an approach are prohibited.</li>
        <li>No SBAS on the route: check RAIM. Predicted outage over 5 minutes means delay, cancel or reroute.</li>
        <li>Plan a required alternate on LNAV minimums or a ground-based approach, not LPV or LNAV/VNAV.</li>
        <li><b>IFR approaches are prohibited if anything blocks view of or access to the GNS or CDI, such as a throw-over yoke.</b> This airplane has a throw-over wheel.</li>
        <li>LNAV+V advisory glidepath: minimums stay LNAV.</li>
        <li>No GPS guidance on the final segment of ILS, LOC, LDA, SDF approaches.</li>
        <li>The autopilot coupling boxes in this copy are blank. Confirm what the installation allows.</li>
      </ul>
    </div>
    <div class="card">
      <div class="card-head"><h3>GNS abnormal procedures</h3><span class="src">213–215</span></div>
      <ul class="plain">
        <li><b>DR (amber):</b> dead reckoning from last fix. Enroute and oceanic only; no CDI guidance. Use other navaids if available.</li>
        <li><b>INTEG (amber):</b> loss of integrity. Revert to another means of navigation.</li>
        <li><b>Approach downgrade before FAF:</b> vertical guidance removed, continue to LNAV minimums. After FAF, "ABORT APPROACH" and go missed.</li>
        <li><b>COM tuning lost, no other COM:</b> press and hold COM RMT XFR (if installed) 2 s for 121.5.</li>
        <li><b>TAWS PULL UP (if equipped):</b> autopilot off, max power climb at V<sub>X</sub>, then climb to safe altitude and tell ATC.</li>
      </ul>
    </div>
    <div class="card">
      <div class="card-head"><h3>Garmin GTX transponder, ADS-B Out</h3><span class="src">137, 145–149</span></div>
      <ul class="plain">
        <li>ADS-B Out compliance (14 CFR 91.227) needs a working pressure-altitude source and GPS/SBAS position source.</li>
        <li>Before takeoff: ADS-B TX (or 1090ES TX) ON, NO ADSB / NO 1090ES TX annunciation out.</li>
        <li>GPS position lost: ADS-B Out stops; transponder still replies.</li>
        <li>Pressure Altitude Broadcast Inhibit only when ATC asks.</li>
        <li>IDENT sends the SPI pulse for 18 seconds.</li>
        <li>The model checkboxes in this copy are hard to read. Check which GTX is on the panel.</li>
      </ul>
    </div>
    <div class="card">
      <div class="card-head"><h3>Emergency static source</h3><span class="src">155</span></div>
      <p>Valve OPEN, correct from the table, close fully when done. Storm window closed, heater on or off, gear and flaps up:</p>
      <div class="tbl"><table>
        <thead><tr><th class="n">Correct airspeed kt</th><th class="n">Indicator shows kt</th><th class="n">Altimeter error at this IAS</th></tr></thead>
        <tbody>
          <tr><td class="n">69</td><td class="n">72</td><td class="n">—</td></tr>
          <tr><td class="n">78</td><td class="n">80</td><td class="n">+25 ft</td></tr>
          <tr><td class="n">87</td><td class="n">89</td><td class="n">+25 ft</td></tr>
          <tr><td class="n">104</td><td class="n">109</td><td class="n">+60 ft</td></tr>
          <tr><td class="n">122</td><td class="n">129</td><td class="n">+95 ft</td></tr>
          <tr><td class="n">139</td><td class="n">148</td><td class="n">+135 ft</td></tr>
        </tbody></table></div>
      <p class="hint">Both instruments generally read high. With gear and flaps down at low speed the altimeter can read slightly low.</p>
    </div>
  </div>
</section>

<!-- ============ OWNER NOTES ============ -->
<section class="view" id="v-owner" hidden>
  <div style="display:grid;gap:8px">
    <span class="eyebrow">p.160–161 · typed notes left by a previous owner</span>
    <h2>Previous owner's notes</h2>
  </div>
  <div class="g-note"><strong>Not approved data.</strong> These are one pilot's habits and observations. Some conflict with the book (for example skipping the short-field speeds). Read them for insight into how this particular airplane behaves, and fly the AFM.</div>
  <div class="grid2">
    <div class="card">
      <h3>Airplane quirks</h3>
      <ul class="plain">
        <li>Left fuel gauge sometimes sticks at half full.</li>
        <li>Don't fill oil above 7 qt; the left engine throws out the 8th. Left engine used a quart per 5 hr, right per 7 hr (at the time).</li>
        <li>Use lighter oil: 20W-30 through most of fall and spring. Make sure the correct filter goes on for the turbos.</li>
        <li>Left landing-light switch = nose light. Right = wheel light (use for taxi).</li>
        <li>Typical cruise CHT: left 300°, right 340°. EGT: left peaks lower than right.</li>
        <li>File as Beech D95/A.</li>
      </ul>
    </div>
    <div class="card">
      <h3>Turbo technique</h3>
      <ul class="plain">
        <li>MP reads about 2 in. high with the turbos operating, so "25 in. × 2300" is really 23 in.</li>
        <li>Engage: push in until your knuckles reach the fuel quadrant, then work ½ turns back and forth until MP comes up. Very sensitive. Usually engaged at 6,000–7,000 ft.</li>
        <li>Disengage slowly to avoid shock cooling, no more than 2 in. at a time. When fully off the fuel flow jumps richer; pull mixtures back.</li>
        <li>Turbo climb: 27 in. × 2500 at 135 mph, about 12 gph (13 gph if climbing at 108 mph; watch CHT). Cruise 26 in. × 2400 at 10 gph or 25 in. × 2300 at 9 gph.</li>
      </ul>
    </div>
    <div class="card">
      <h3>Power settings used</h3>
      <ul class="plain">
        <li>Cruise climb 135 mph hot / 125 mph cold at 12 gph (72 pph); cowls by CHT and OAT.</li>
        <li>Cruise 23 in. × 2300 ≈ 8 gph; 24 in. × 2400 ≈ 9 gph.</li>
        <li>Letdown: keep cruise power or 19–22 in. × 2200, mixture lean.</li>
        <li>Taxi lean: back 1–1½ in. at sea level, 2–2½ in. at 5,000 ft.</li>
        <li>Boost pumps all the time above 8,000 ft and when switching tanks after running one dry.</li>
        <li>Ran a tank dry? After refuelling, taxi on that tank to purge it.</li>
      </ul>
    </div>
    <div class="card">
      <h3>Hot start (owner's version)</h3>
      <ul class="plain">
        <li>Throttles forward 1–2 in., mixture idle, props forward, starter.</li>
        <li>When it fires, advance mixture; use pumps if it starts to die.</li>
        <li>No luck: pumps on, mixture rich to over-prime, then repeat.</li>
      </ul>
      <p class="hint">Compare with the book hot/flooded start on the Checklists tab.</p>
    </div>
  </div>
  <div class="card">
    <h3>Speeds the owner used</h3>
    <div class="tbl" style="border:0"><table>
      <thead><tr><th>Speed</th><th class="n">Typed (mph)</th><th class="n">Handwritten (kt)</th><th>Book says</th></tr></thead>
      <tbody>
        <tr><td>V<sub>MC</sub></td><td class="n">80</td><td class="n">70</td><td>69.5 kt CAS</td></tr>
        <tr><td>Liftoff</td><td class="n">85–90</td><td class="n">75</td><td>74 kt normal</td></tr>
        <tr><td>V<sub>SSE</sub> (safe single-engine)</td><td class="n">90</td><td class="n">78</td><td>not in book</td></tr>
        <tr><td>V<sub>X</sub></td><td class="n">80</td><td class="n">70</td><td>72 kt at 5,000 ft</td></tr>
        <tr><td>V<sub>Y</sub></td><td class="n">108</td><td class="n">—</td><td>"not actually but it's what I use"; book 95.5 kt</td></tr>
        <tr><td>V<sub>XSE</sub></td><td class="n">98</td><td class="n">85</td><td>85 kt</td></tr>
        <tr><td>V<sub>YSE</sub></td><td class="n">108</td><td class="n">94</td><td>94 kt</td></tr>
        <tr><td>Cruise climb</td><td class="n">135</td><td class="n">118 / 120</td><td>121.5 kt book</td></tr>
        <tr><td>V<sub>LE</sub> / V<sub>A</sub></td><td class="n">165 / 160</td><td class="n">—</td><td>143 / 139 kt; 200 mph emergency</td></tr>
      </tbody></table></div>
    <p class="hint">The owner wrote: "Do not use short field speeds as given in book. Lift off at 85 &amp; hold 90 until over obstacle with 20 flaps." Treat this as one pilot's opinion.</p>
  </div>
</section>

<!-- ============ QUIZ ============ -->
<section class="view" id="v-quiz" hidden>
  <div style="display:grid;gap:8px">
    <span class="eyebrow">Self-test</span>
    <h2>Quiz &amp; flashcards</h2>
  </div>
  <div class="qbar">
    <div class="seg" role="group" aria-label="Mode">
      <button id="mQuiz" aria-pressed="true">Quiz</button>
      <button id="mFlash" aria-pressed="false">Flashcards</button>
    </div>
    <label for="qTopic" class="eyebrow">Topic</label>
    <select id="qTopic"></select>
    <button class="btn sm" id="qRestart">Shuffle &amp; restart</button>
  </div>
  <div class="progress"><span id="qProg" style="width:0"></span></div>
  <div id="qStage"></div>
</section>

<p class="g-foot">Built from the aircraft's scanned POH binder (221 pages). Page numbers are PDF pages. Study aid only: the documents in the airplane, its placards, and its actual instrument markings govern.</p>
</div>
@endsection
