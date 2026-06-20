<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration — SYNEM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green:  #2ECC71;
            --yellow: #F1C40F;
            --red:    #C8102E;
            --blue:   #1547c0;
            --blue2:  #0f3a9e;
            --blue3:  #0a2a7a;
            --white:  #ffffff;
            --text:   #1a2340;
            --muted:  #5a6a8a;
            --border: #dce4f5;
            --bg:     #f0f4ff;
        }

        html, body { height: 100%; font-family: 'Montserrat', sans-serif; overflow: hidden; }

        /* ── CAROUSEL ─────────────────────────────────────────── */
        .carousel-bg { position: fixed; inset: 0; z-index: 0; }
        .slide {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
            opacity: 0; transform: scale(1.07);
            transition: opacity 1.4s ease, transform 8s ease;
        }
        .slide.active { opacity: 1; transform: scale(1); }
        /* Images : enseignants & éducation en Afrique / Mali */
        .slide:nth-child(1) { background-image: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1920&q=80&fit=crop'); }
        .slide:nth-child(2) { background-image: url('https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=1920&q=80&fit=crop'); }
        .slide:nth-child(3) { background-image: url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=1920&q=80&fit=crop'); }
        .slide:nth-child(4) { background-image: url('https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=1920&q=80&fit=crop'); }

        /* overlay bleu léger — images visibles */
        .overlay {
            position: fixed; inset: 0; z-index: 1;
            background: linear-gradient(
                to bottom,
                rgba(15,58,158,.35) 0%,
                rgba(10,42,122,.25) 60%,
                rgba(10,42,122,.55) 100%
            );
        }

        /* ── PAGE ─────────────────────────────────────────────── */
        .page {
            position: relative; z-index: 2;
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 1.5rem;
        }

        /* ── CARD BLANCHE ─────────────────────────────────────── */
        .card {
            width: 100%; max-width: 460px;
            background: var(--white);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(10,42,122,.45), 0 2px 0 rgba(255,255,255,.8) inset;
            animation: fadeUp .65s cubic-bezier(.16,1,.3,1) both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(28px) scale(.97); }
            to   { opacity: 1; transform: translateY(0)   scale(1); }
        }

        /* ── CARD HEADER BLEU ─────────────────────────────────── */
        .card-header {
            background: linear-gradient(135deg, var(--blue) 0%, var(--blue3) 100%);
            padding: 2.2rem 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .card-header::before {
            content: '';
            position: absolute; top: -60px; right: -60px;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(255,255,255,.07);
        }
        .card-header::after {
            content: '';
            position: absolute; bottom: -55px; left: -40px;
            width: 170px; height: 170px; border-radius: 50%;
            background: rgba(255,255,255,.05);
        }

        /* icône */
        .logo-icon {
            width: 68px; height: 68px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            background: rgba(255,255,255,.15);
            border: 2px solid rgba(255,255,255,.3);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.9rem; color: #fff;
            position: relative; z-index: 1;
        }

        /* barre tricolore */
        .tricolor-bar {
            display: flex; justify-content: center; gap: 3px;
            margin-bottom: .9rem;
            position: relative; z-index: 1;
        }
        .tricolor-bar span { display: block; width: 38px; height: 3px; border-radius: 2px; }
        .t-green  { background: var(--green); }
        .t-yellow { background: var(--yellow); }
        .t-red    { background: var(--red); }

        /* SYNEM tricolore */
        .logo-text {
            font-size: 2.6rem; font-weight: 800;
            letter-spacing: -.01em; line-height: 1;
            position: relative; z-index: 1;
        }
        .logo-text .sy { color: var(--green); }
        .logo-text .ne { color: var(--yellow); }
        .logo-text .m  { color: var(--red); }

        .card-sub {
            font-size: .68rem; color: rgba(255,255,255,.55);
            margin-top: .45rem; letter-spacing: .06em;
            text-transform: uppercase; position: relative; z-index: 1;
        }

        /* ── CARD BODY BLANC ──────────────────────────────────── */
        .card-body { padding: 2rem 2.5rem 2rem; background: var(--white); }

        /* ── ALERTS ───────────────────────────────────────────── */
        .alert {
            display: flex; align-items: flex-start; gap: .6rem;
            padding: .85rem 1rem; border-radius: 12px;
            font-size: .78rem; margin-bottom: 1.4rem; line-height: 1.5;
        }
        .alert i { font-size: .95rem; flex-shrink: 0; margin-top: 2px; }
        .alert ul { margin: .3rem 0 0 1rem; }
        .alert-danger  { background: #fff0f3; border: 1px solid #fecdd3; color: #9b1c2a; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }

        /* ── FIELDS ───────────────────────────────────────────── */
        .field { margin-bottom: 1.25rem; }
        .field label {
            display: block; font-size: .68rem; font-weight: 700;
            color: var(--muted); letter-spacing: .09em;
            text-transform: uppercase; margin-bottom: .45rem;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 1rem; top: 50%;
            transform: translateY(-50%);
            color: #b0bcd4; font-size: .95rem;
            pointer-events: none; transition: color .25s;
        }
        .form-input {
            width: 100%;
            padding: .88rem 3rem .88rem 2.8rem;
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-family: 'Montserrat', sans-serif;
            font-size: .87rem; color: var(--text);
            outline: none;
            transition: border-color .25s, background .25s, box-shadow .25s;
        }
        .form-input::placeholder { color: #b0bcd4; }
        .form-input:focus {
            border-color: var(--blue);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(21,71,192,.12);
        }
        .form-input:focus + .input-icon { color: var(--blue); }

        .eye-btn {
            position: absolute; right: 1rem; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: #b0bcd4; font-size: .95rem; padding: 0;
            transition: color .2s;
        }
        .eye-btn:hover { color: var(--blue); }

        /* ── REMEMBER ─────────────────────────────────────────── */
        .remember-row {
            display: flex; align-items: center;
            justify-content: space-between; margin-bottom: 1.7rem;
        }
        .check-label {
            display: flex; align-items: center; gap: .45rem;
            font-size: .76rem; color: var(--muted);
            cursor: pointer; user-select: none;
        }
        .check-label input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: var(--blue); cursor: pointer;
        }
        .forgot-link {
            font-size: .76rem; color: var(--blue);
            text-decoration: none; font-weight: 600;
            transition: opacity .2s;
        }
        .forgot-link:hover { opacity: .7; }

        /* ── BUTTON ───────────────────────────────────────────── */
        .btn-submit {
            width: 100%; padding: .95rem;
            background: linear-gradient(135deg, var(--blue) 0%, var(--blue2) 100%);
            color: #fff; border: none; border-radius: 12px;
            font-family: 'Montserrat', sans-serif;
            font-size: .88rem; font-weight: 700; letter-spacing: .04em;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: .55rem;
            box-shadow: 0 6px 22px rgba(21,71,192,.35);
            transition: transform .15s, box-shadow .2s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(21,71,192,.45);
        }
        .btn-submit:active { transform: translateY(0); }

        /* ── DIVIDER ──────────────────────────────────────────── */
        .divider {
            display: flex; align-items: center; gap: .75rem;
            margin: 1.3rem 0 1rem;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1;
            height: 1px; background: var(--border);
        }
        .divider span { font-size: .67rem; color: #b0bcd4; white-space: nowrap; }

        /* ── SECURITY NOTE ────────────────────────────────────── */
        .security-note {
            display: flex; align-items: center; gap: .55rem;
            background: var(--bg); border: 1px solid var(--border);
            border-radius: 10px; padding: .75rem 1rem;
        }
        .security-note i { color: var(--blue); font-size: .9rem; flex-shrink: 0; }
        .security-note p { font-size: .69rem; color: var(--muted); margin: 0; line-height: 1.5; }

        /* ── BACK LINK ────────────────────────────────────────── */
        .back-link {
            display: block; text-align: center; margin-top: 1.3rem;
            font-size: .72rem; color: var(--muted);
            text-decoration: none; transition: color .2s;
        }
        .back-link:hover { color: var(--blue); }

        /* ── SLIDE MESSAGE (bas gauche) ───────────────────────── */
        .slide-message {
            position: fixed;
            bottom: 4.5rem; left: 2.5rem;
            z-index: 3;
            max-width: 380px;
            opacity: 0;
            transform: translateY(10px);
            transition: opacity .6s ease, transform .6s ease;
            pointer-events: none;
        }
        .slide-message.active { opacity: 1; transform: translateY(0); }

        .slide-tag {
            display: inline-flex; align-items: center; gap: .4rem;
            background: rgba(21,71,192,.75);
            border: 1px solid rgba(255,255,255,.2);
            backdrop-filter: blur(8px);
            border-radius: 50px;
            padding: .3rem .85rem;
            font-size: .63rem; font-weight: 700;
            color: rgba(255,255,255,.85);
            letter-spacing: .1em; text-transform: uppercase;
            margin-bottom: .55rem;
        }
        .slide-tag i { font-size: .7rem; }

        .slide-quote {
            font-size: 1.15rem; font-weight: 700;
            color: #fff;
            line-height: 1.4;
            text-shadow: 0 2px 12px rgba(0,0,0,.5);
        }
        .slide-quote span {
            color: var(--yellow);
        }

        /* ── CAROUSEL DOTS ────────────────────────────────────── */
        .carousel-dots {
            position: fixed; bottom: 2rem; left: 2.5rem;
            z-index: 3; display: flex; gap: .5rem; align-items: center;
        }
        .dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: rgba(255,255,255,.35);
            cursor: pointer; transition: background .3s, transform .3s, width .3s;
        }
        .dot.active {
            background: #fff;
            width: 22px; border-radius: 4px;
        }

        @media (max-width: 520px) {
            .card-body  { padding: 1.6rem 1.4rem; }
            .card-header { padding: 1.8rem 1.4rem 1.5rem; }
        }
    </style>
</head>
<body>

    <!-- CAROUSEL -->
    <div class="carousel-bg">
        <div class="slide active"></div>
        <div class="slide"></div>
        <div class="slide"></div>
        <div class="slide"></div>
    </div>
    <div class="overlay"></div>

    <!-- Messages contextuels par slide -->
    <div class="slide-message active" data-index="0">
        <div class="slide-tag"><i class="bi bi-book-fill"></i> Éducation · Mali</div>
        <div class="slide-quote">Pour une <span>éducation de qualité</span><br>dans toutes les régions du Mali</div>
    </div>
    <div class="slide-message" data-index="1">
        <div class="slide-tag"><i class="bi bi-people-fill"></i> Syndicat · SYNEM</div>
        <div class="slide-quote"><span>Unis et solidaires</span><br>pour défendre les droits des enseignants</div>
    </div>
    <div class="slide-message" data-index="2">
        <div class="slide-tag"><i class="bi bi-stars"></i> Avenir · Jeunesse</div>
        <div class="slide-quote">Ensemble, nous <span>construisons l'avenir</span><br>de la nation malienne</div>
    </div>
    <div class="slide-message" data-index="3">
        <div class="slide-tag"><i class="bi bi-megaphone-fill"></i> Engagement · Syndicat</div>
        <div class="slide-quote">SYNEM — <span>La voix des enseignants</span><br>au service de l'éducation</div>
    </div>

    <div class="carousel-dots">
        <div class="dot active" onclick="goTo(0)"></div>
        <div class="dot" onclick="goTo(1)"></div>
        <div class="dot" onclick="goTo(2)"></div>
        <div class="dot" onclick="goTo(3)"></div>
    </div>

    <!-- CARD -->
    <div class="page">
        <div class="card">

            <!-- HEADER BLEU -->
            <div class="card-header">
                <div class="logo-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="tricolor-bar">
                    <span class="t-green"></span>
                    <span class="t-yellow"></span>
                    <span class="t-red"></span>
                </div>
                <div class="logo-text">
                    <span class="sy">SY</span><span class="ne">NE</span><span class="m">M</span>
                </div>
                <div class="card-sub">Syndicat National des Enseignants du Mali</div>
            </div>

            <!-- BODY BLANC -->
            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            <strong>Identifiants incorrects</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if(session('status'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="field">
                        <label for="email">Adresse e-mail</label>
                        <div class="input-wrap">
                            <input type="email" id="email" name="email" class="form-input"
                                   value="{{ old('email') }}" placeholder="admin@synem.ml"
                                   required autofocus autocomplete="email">
                            <i class="bi bi-envelope input-icon"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label for="password">Mot de passe</label>
                        <div class="input-wrap">
                            <input type="password" id="password" name="password" class="form-input"
                                   placeholder="••••••••" required autocomplete="current-password">
                            <i class="bi bi-lock input-icon"></i>
                            <button type="button" class="eye-btn" id="eyeBtn">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="remember-row">
                        <label class="check-label">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            Se souvenir de moi
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Mot de passe oublié ?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Se connecter
                    </button>
                </form>

                <div class="divider"><span>espace sécurisé</span></div>

                <div class="security-note">
                    <i class="bi bi-shield-check"></i>
                    <p>Accès réservé aux administrateurs. Bloqué après 5 tentatives échouées (15 min).</p>
                </div>

                <a href="{{ route('accueil') }}" class="back-link">
                    <i class="bi bi-arrow-left"></i> Retour au site public
                </a>
            </div>
        </div>
    </div>

    <script>
        const slides   = document.querySelectorAll('.slide');
        const dots     = document.querySelectorAll('.dot');
        const messages = document.querySelectorAll('.slide-message');
        let current = 0, timer;

        function goTo(n) {
            slides[current].classList.remove('active');
            dots[current].classList.remove('active');
            messages[current].classList.remove('active');
            current = n;
            slides[current].classList.add('active');
            dots[current].classList.add('active');
            setTimeout(() => messages[current].classList.add('active'), 200);
            clearInterval(timer);
            timer = setInterval(next, 6000);
        }
        function next() { goTo((current + 1) % slides.length); }
        timer = setInterval(next, 6000);

        document.getElementById('eyeBtn').addEventListener('click', () => {
            const p = document.getElementById('password');
            const i = document.getElementById('eyeIcon');
            const show = p.type === 'password';
            p.type = show ? 'text' : 'password';
            i.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    </script>
</body>
</html>
