/*
 * Exam runner. In-progress state lives in localStorage so a refresh or a
 * closed tab can be resumed; grading happens on the server at submit time.
 */
const EXAM = JSON.parse(document.getElementById('exam-data').textContent);
const SECTIONS = EXAM.sections;
const REFS = EXAM.refs;
const byNum = Object.fromEntries(EXAM.questions.map(q => [q.n, q]));
const secById = id => SECTIONS.find(s => s.id === id);
const secOf = n => SECTIONS.find(s => s.questions.includes(n));

const KEY = `exam:${EXAM.slug}:v1`;
const LAST_KEY = `exam:${EXAM.slug}:last-attempt`;
let S = null; // {order:{secId:[nums]}, secs:[ids], ans:{n:idx}, flags:{n:1}, cur:{sec,i}, start}
const store = {
    get: k => { try { const r = localStorage.getItem(k); return r ? JSON.parse(r) : null } catch (e) { return null } },
    set: (k, v) => { try { localStorage.setItem(k, JSON.stringify(v)) } catch (e) {} },
    del: k => { try { localStorage.removeItem(k) } catch (e) {} },
};
const save = () => store.set(KEY, S);
const shuffle = a => { a = a.slice(); for (let i = a.length - 1; i > 0; i--) { const j = Math.floor(Math.random() * (i + 1)); [a[i], a[j]] = [a[j], a[i]] } return a };
const esc = s => String(s).replace(/[&<>"]/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));

const app = document.getElementById('app'), dock = document.getElementById('dock'), meta = document.getElementById('meta');
let confirming = false, submitting = false, submitError = '', tick = null;

function fmtTime(ms) { const t = Math.max(0, Math.floor(ms / 1000)); const h = Math.floor(t / 3600), m = Math.floor(t % 3600 / 60), s = t % 60; return (h ? h + ':' : '') + String(m).padStart(h ? 2 : 1, '0') + ':' + String(s).padStart(2, '0') }
function startClock() { clearInterval(tick); tick = setInterval(() => { if (S) meta.textContent = 'Elapsed ' + fmtTime(Date.now() - S.start) }, 1000) }

/* ---------- start (rendered server-side; this just wires it up) ---------- */
function begin(secs) {
    const order = {};
    secs.forEach(id => order[id] = shuffle(secById(id).questions));
    S = { order, secs, ans: {}, flags: {}, cur: { sec: secs[0], i: 0 }, start: Date.now() };
    save(); renderExam();
}

function initStart() {
    const saved = store.get(KEY);
    const last = store.get(LAST_KEY);

    document.getElementById('go').onclick = () => {
        const secs = SECTIONS.filter(s => document.getElementById('pick-' + s.id).checked).map(s => s.id);
        if (!secs.length) { document.getElementById('pickErr').hidden = false; return }
        begin(secs);
    };

    const resume = document.getElementById('resume');
    if (saved) {
        resume.textContent = `Resume exam in progress (${Object.keys(saved.ans).length} answered)`;
        resume.hidden = false;
        resume.onclick = () => { S = saved; renderExam() };
    }

    const lastLink = document.getElementById('last-results');
    if (last) { lastLink.href = last; lastLink.hidden = false }

    // "Take it again" from the results page links here with ?retake=sec1,sec2
    const params = new URLSearchParams(location.search);
    if (params.has('retake')) {
        history.replaceState(null, '', location.pathname);
        const secs = params.get('retake').split(',').filter(id => secById(id));
        if (secs.length) begin(secs);
    }
}

/* ---------- exam ---------- */
const curNum = () => S.order[S.cur.sec][S.cur.i];
function flatIndex() { let k = 0; for (const id of S.secs) { if (id === S.cur.sec) return k + S.cur.i; k += S.order[id].length } }
const total = () => S.secs.reduce((t, id) => t + S.order[id].length, 0);
function step(d) {
    let si = S.secs.indexOf(S.cur.sec), i = S.cur.i + d;
    if (i < 0) { if (si === 0) return; si--; i = S.order[S.secs[si]].length - 1 }
    else if (i >= S.order[S.secs[si]].length) { if (si === S.secs.length - 1) { confirming = true; renderExam(); return } si++; i = 0 }
    S.cur = { sec: S.secs[si], i }; save(); renderExam(true);
}

function refHTML(key, qn) {
    const r = REFS[key]; let body = '';
    if (r.pre) body = `<pre>${esc(r.pre)}</pre>`;
    if (r.imgs.length) {
        if (r.imgs.length > 1) {
            body = `<div class="tabs" role="tablist">${r.imgs.map((im, i) => `<button type="button" role="tab" class="${i ? '' : 'on'}" data-ref="${key}-${qn}" data-i="${i}">${esc(im[0])}</button>`).join('')}</div>
        <img id="img-${key}-${qn}" src="${r.imgs[0][1]}" alt="${esc(r.t)} – ${esc(r.imgs[0][0])}" loading="lazy">`;
        } else body = `<img src="${r.imgs[0][1]}" alt="${esc(r.t)}" loading="lazy">`;
    }
    return `<details class="ref" open><summary>${esc(r.t)}</summary><div class="body">${body}</div></details>`;
}

function renderExam(focusTop) {
    dock.hidden = false; startClock(); meta.textContent = 'Elapsed ' + fmtTime(Date.now() - S.start);
    const n = curNum(), q = byNum[n], sec = secOf(n), picked = S.ans[n];
    const answered = Object.keys(S.ans).length, tot = total(), unanswered = tot - answered, flagged = Object.keys(S.flags).length;

    const rail = `<nav class="rail" aria-label="Sections">${S.secs.map(id => {
        const s = secById(id); const a = S.order[id].filter(x => S.ans[x] != null).length, t = S.order[id].length;
        return `<button type="button" data-sec="${id}" class="${id === S.cur.sec ? 'on' : ''}"><span class="nm">${esc(s.short || s.name)}</span><span class="ct">${a}/${t} answered</span><span class="bar"><i style="width:${a / t * 100}%"></i></span></button>`
    }).join('')}</nav>`;

    const conf = confirming ? `<section class="sheet confirm" role="alertdialog" aria-labelledby="cft">
    <h2 id="cft" style="font-size:22px">Submit the exam?</h2>
    <p>${unanswered ? `You have <b>${unanswered}</b> unanswered question${unanswered > 1 ? 's' : ''}. Unanswered questions are marked wrong.` : 'All questions are answered.'}${flagged ? ` ${flagged} question${flagged > 1 ? 's are' : ' is'} still flagged.` : ''}</p>
    ${submitError ? `<p class="note" style="color:var(--bad)">${esc(submitError)}</p>` : ''}
    <div class="row"><button class="btn primary" id="submit" ${submitting ? 'disabled' : ''}>${submitting ? 'Submitting…' : 'Submit and see results'}</button><button class="btn" id="back">Keep working</button></div></section>` : '';

    const refs = q.r.map(k => refHTML(k, n));
    const vnc = q.v && EXAM.externalChartNote ? `<div class="warn">${esc(EXAM.externalChartNote)}</div>` : '';

    app.innerHTML = `${rail}${conf}
  <section class="sheet" id="qcard">
    <div class="qhead"><span class="qnum">${esc(sec.short || sec.name)} · ${S.cur.i + 1} of ${S.order[S.cur.sec].length}</span><span class="label">Question ${flatIndex() + 1} / ${tot}</span></div>
    <p class="stem">${q.s}</p>
    <ul class="opts" role="radiogroup" aria-label="Answers">
      ${q.o.map((o, i) => `<li><label class="opt"><input type="radio" name="ans" id="q${n}o${i + 1}" value="${i + 1}" ${picked === i + 1 ? 'checked' : ''}><span class="k">${i + 1}</span><span>${esc(o)}</span></label></li>`).join('')}
    </ul>
    ${(vnc || refs.length) ? `<div class="refs">${vnc}${refs.join('')}</div>` : ''}
    <details class="map"><summary>Question map – ${answered} of ${tot} answered${flagged ? `, ${flagged} flagged` : ''}</summary>
      ${S.secs.map(id => { const s = secById(id); return `<div class="label" style="margin-top:12px">${esc(s.short || s.name)}</div><div class="grid">${S.order[id].map((x, i) => `<button type="button" data-jump="${id}:${i}" class="${S.ans[x] != null ? 'ans' : ''} ${S.flags[x] ? 'flg' : ''} ${id === S.cur.sec && i === S.cur.i ? 'cur' : ''}" aria-label="${esc(s.short || s.name)} question ${i + 1}${S.ans[x] != null ? ', answered' : ''}${S.flags[x] ? ', flagged' : ''}">${i + 1}</button>`).join('')}</div>` }).join('')}
      <div class="legend"><span><i style="background:var(--nav-soft);border-color:var(--nav)"></i>Answered</span><span><i style="background:var(--mag);border-color:var(--mag);border-radius:50%"></i>Flagged</span></div>
    </details>
  </section>`;

    // wiring
    app.querySelectorAll('input[name="ans"]').forEach(inp => inp.onchange = () => {
        S.ans[n] = +inp.value; save();
        const a = S.order[S.cur.sec].filter(x => S.ans[x] != null).length, t = S.order[S.cur.sec].length, b = app.querySelector(`.rail button[data-sec="${S.cur.sec}"]`);
        b.querySelector('.ct').textContent = `${a}/${t} answered`; b.querySelector('.bar i').style.width = a / t * 100 + '%';
        const g = app.querySelector('.grid button.cur'); if (g) g.classList.add('ans');
        const sm = app.querySelector('.map summary'); const A = Object.keys(S.ans).length, F = Object.keys(S.flags).length; sm.textContent = `Question map – ${A} of ${tot} answered${F ? `, ${F} flagged` : ''}`;
    });
    app.querySelectorAll('.rail button').forEach(b => b.onclick = () => { S.cur = { sec: b.dataset.sec, i: 0 }; confirming = false; save(); renderExam(true) });
    app.querySelectorAll('[data-jump]').forEach(b => b.onclick = () => { const [id, i] = b.dataset.jump.split(':'); S.cur = { sec: id, i: +i }; confirming = false; save(); renderExam(true) });
    app.querySelectorAll('.tabs button').forEach(b => b.onclick = () => {
        const key = b.dataset.ref.slice(0, b.dataset.ref.lastIndexOf('-')); const im = REFS[key].imgs[+b.dataset.i];
        const img = document.getElementById('img-' + b.dataset.ref); img.src = im[1]; img.alt = REFS[key].t + ' – ' + im[0];
        b.parentElement.querySelectorAll('button').forEach(x => x.classList.toggle('on', x === b));
    });
    app.querySelectorAll('.ref img').forEach(im => im.onclick = () => openLB(im));
    if (confirming) { document.getElementById('submit').onclick = submit; document.getElementById('back').onclick = () => { confirming = false; submitError = ''; renderExam() } }

    const fl = document.getElementById('flag'); fl.setAttribute('aria-pressed', S.flags[n] ? 'true' : 'false'); fl.textContent = S.flags[n] ? 'Flagged' : 'Flag';
    document.getElementById('prev').disabled = (S.secs.indexOf(S.cur.sec) === 0 && S.cur.i === 0);
    const last = S.cur.sec === S.secs[S.secs.length - 1] && S.cur.i === S.order[S.cur.sec].length - 1;
    document.getElementById('next').textContent = last ? 'Review & submit' : 'Next →';
    if (confirming) document.querySelector('.confirm').scrollIntoView({ block: 'start' });
    else if (focusTop) window.scrollTo({ top: 0 });
}

document.getElementById('prev').onclick = () => { confirming = false; step(-1) };
document.getElementById('next').onclick = () => step(1);
document.getElementById('finish').onclick = () => { confirming = true; renderExam() };
document.getElementById('flag').onclick = () => { const n = curNum(); if (S.flags[n]) delete S.flags[n]; else S.flags[n] = 1; save(); renderExam() };
document.addEventListener('keydown', e => {
    if (!S || dock.hidden || e.target.closest('input[type=checkbox]')) return;
    if (!document.getElementById('lb').hidden) { if (e.key === 'Escape') closeLB(); return }
    if (['1', '2', '3', '4'].includes(e.key)) { const r = document.getElementById(`q${curNum()}o${e.key}`); if (r) { r.checked = true; r.dispatchEvent(new Event('change')) } }
    else if (e.key === 'ArrowRight' && !e.target.closest('input')) step(1);
    else if (e.key === 'ArrowLeft' && !e.target.closest('input')) { confirming = false; step(-1) }
});

/* lightbox */
const lb = document.getElementById('lb'), lbimg = document.getElementById('lbimg');
function openLB(im) { lbimg.src = im.src; lbimg.alt = im.alt; lb.hidden = false }
function closeLB() { lb.hidden = true }
lb.onclick = closeLB;

/* ---------- submit ---------- */
async function submit() {
    if (submitting) return;
    submitting = true; submitError = ''; renderExam();
    let res;
    try {
        res = await fetch(EXAM.submitUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ sections: S.secs, answers: S.ans, flags: Object.keys(S.flags).map(Number), started_at: S.start }),
        });
    } catch (e) {
        res = null;
    }
    if (!res || !res.ok) {
        submitting = false;
        submitError = !res ? 'Couldn’t reach the server. Your answers are saved, so try again.'
            : res.status === 419 ? 'Your session expired. Refresh the page and resume; your answers are saved.'
            : 'Something went wrong submitting the exam. Your answers are saved, so try again.';
        renderExam();
        return;
    }
    const { url } = await res.json();
    clearInterval(tick);
    store.del(KEY); store.set(LAST_KEY, url);
    location.href = url;
}

initStart();
