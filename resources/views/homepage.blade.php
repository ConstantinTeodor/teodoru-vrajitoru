<!doctype html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#071527">
    <title>Teodoru's Christmas Countdown 🎄</title>
    <style>
        :root {
            color-scheme: dark;
            --snow: #f7fbff;
            --ice: #b9edff;
            --red: #f14d61;
            --green: #68d391;
            --gold: #ffd66b;
        }

        * { box-sizing: border-box; }
        html, body { width: 100%; min-height: 100%; margin: 0; }

        body {
            min-height: 100svh;
            overflow: hidden;
            font-family: "Trebuchet MS", "Arial Rounded MT Bold", system-ui, sans-serif;
            background:
                radial-gradient(circle at 50% 115%, rgba(42, 156, 156, .34), transparent 42%),
                radial-gradient(circle at 12% 12%, rgba(58, 118, 160, .24), transparent 28%),
                linear-gradient(160deg, #06111f 0%, #0b2740 55%, #0b1c31 100%);
        }

        .aurora {
            position: fixed;
            inset: -30% -20% auto;
            height: 68%;
            pointer-events: none;
            background:
                radial-gradient(ellipse at 35% 0%, rgba(74, 222, 128, .2), transparent 42%),
                radial-gradient(ellipse at 65% 5%, rgba(45, 212, 191, .19), transparent 40%),
                radial-gradient(ellipse at 85% 0%, rgba(244, 114, 182, .12), transparent 35%);
            filter: blur(35px);
            animation: aurora 9s ease-in-out infinite alternate;
        }

        .stars, .snow, .decorations {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .stars {
            opacity: .48;
            background-image:
                radial-gradient(circle, white 0 1px, transparent 1.5px),
                radial-gradient(circle, var(--ice) 0 1px, transparent 1.5px);
            background-position: 0 0, 40px 55px;
            background-size: 95px 95px, 137px 137px;
            animation: twinkle 4s ease-in-out infinite alternate;
        }

        .snow { z-index: 5; }
        .snowflake {
            position: absolute;
            top: -24px;
            color: white;
            line-height: 1;
            opacity: var(--opacity);
            filter: drop-shadow(0 0 4px rgba(185, 237, 255, .65));
            animation: snowfall var(--duration) linear infinite;
            animation-delay: var(--delay);
        }

        .ornament {
            position: absolute;
            top: -12px;
            width: 2px;
            height: clamp(78px, 16vh, 160px);
            background: linear-gradient(rgba(255, 255, 255, .46), rgba(255, 255, 255, .08));
            transform-origin: top;
            animation: swing 5s ease-in-out infinite alternate;
        }

        .ornament::after {
            content: "";
            position: absolute;
            bottom: -22px;
            left: 50%;
            width: 42px;
            height: 42px;
            border: 2px solid rgba(255, 255, 255, .45);
            border-radius: 50%;
            background: radial-gradient(circle at 32% 28%, white, var(--color) 16%, color-mix(in srgb, var(--color), black 35%) 78%);
            box-shadow: 0 0 26px color-mix(in srgb, var(--color), transparent 42%);
            transform: translateX(-50%);
        }

        .ornament.one { left: 8%; --color: #f14d61; animation-delay: -1s; }
        .ornament.two { right: 9%; --color: #ffd66b; height: clamp(58px, 12vh, 120px); animation-delay: -3s; }

        .scene {
            position: relative;
            z-index: 3;
            min-height: 100svh;
            display: grid;
            place-items: center;
            padding: max(30px, env(safe-area-inset-top)) 18px max(54px, env(safe-area-inset-bottom));
            isolation: isolate;
        }

        .card {
            position: relative;
            width: min(790px, 94vw);
            padding: clamp(32px, 6vw, 60px) clamp(20px, 6vw, 58px) clamp(28px, 5vw, 48px);
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: clamp(28px, 5vw, 46px);
            text-align: center;
            background: linear-gradient(145deg, rgba(10, 41, 61, .8), rgba(5, 22, 40, .92));
            box-shadow:
                0 34px 100px rgba(0, 0, 0, .46),
                inset 0 1px 0 rgba(255, 255, 255, .19),
                0 0 90px rgba(78, 201, 176, .11);
            backdrop-filter: blur(14px);
            animation: arrive .9s cubic-bezier(.2, .9, .2, 1.1) both, cardFloat 6s 1s ease-in-out infinite;
        }

        .card::before {
            content: "";
            position: absolute;
            inset: -2px;
            z-index: -1;
            border-radius: inherit;
            background: linear-gradient(130deg, rgba(104, 211, 145, .45), transparent 35%, transparent 65%, rgba(241, 77, 97, .4));
            filter: blur(12px);
        }

        .tree {
            position: absolute;
            top: -46px;
            left: 50%;
            transform: translateX(-50%);
            font-size: clamp(66px, 10vw, 90px);
            filter: drop-shadow(0 10px 18px rgba(0, 0, 0, .38));
            animation: treeBounce 3s ease-in-out infinite;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 11px 0 16px;
            padding: 7px 14px;
            border: 1px solid rgba(185, 237, 255, .25);
            border-radius: 999px;
            color: var(--ice);
            background: rgba(185, 237, 255, .07);
            font-size: clamp(.68rem, 2.5vw, .8rem);
            font-weight: 900;
            letter-spacing: .15em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            color: var(--snow);
            font-size: clamp(2.25rem, 7.5vw, 5rem);
            line-height: .95;
            letter-spacing: -.055em;
            text-wrap: balance;
            text-shadow: 0 5px 0 rgba(8, 42, 58, .9), 0 10px 35px rgba(185, 237, 255, .18);
        }

        h1 span {
            display: block;
            margin-top: 10px;
            color: var(--red);
            font-size: .38em;
            line-height: 1.15;
            letter-spacing: .045em;
            text-shadow: none;
        }

        .countdown {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: clamp(7px, 2vw, 14px);
            max-width: 650px;
            margin: clamp(25px, 5vw, 38px) auto 0;
        }

        .unit {
            min-width: 0;
            padding: clamp(13px, 3vw, 21px) 5px clamp(10px, 2.5vw, 16px);
            border: 1px solid rgba(255, 255, 255, .14);
            border-radius: clamp(16px, 3vw, 24px);
            background: rgba(255, 255, 255, .065);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1), 0 12px 24px rgba(0, 0, 0, .16);
        }

        .number {
            display: block;
            color: var(--gold);
            font-size: clamp(1.75rem, 6vw, 3.5rem);
            font-weight: 900;
            font-variant-numeric: tabular-nums;
            line-height: 1;
            text-shadow: 0 0 22px rgba(255, 214, 107, .24);
        }

        .label {
            display: block;
            margin-top: 8px;
            color: rgba(247, 251, 255, .6);
            font-size: clamp(.58rem, 2vw, .72rem);
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .status {
            margin: clamp(20px, 4vw, 28px) auto 0;
            color: rgba(247, 251, 255, .84);
            font-size: clamp(.95rem, 3vw, 1.14rem);
            font-weight: 700;
            line-height: 1.5;
            text-wrap: balance;
        }

        .status strong { color: var(--green); }

        .cheer-button {
            appearance: none;
            margin-top: 21px;
            padding: 12px 19px;
            border: 0;
            border-radius: 999px;
            color: #24121b;
            background: linear-gradient(135deg, var(--snow), var(--ice));
            box-shadow: 0 7px 0 #568fa4, 0 13px 26px rgba(0, 0, 0, .25);
            font: inherit;
            font-size: .9rem;
            font-weight: 900;
            cursor: pointer;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .cheer-button:hover { transform: translateY(-2px) rotate(-1deg); box-shadow: 0 9px 0 #568fa4, 0 17px 30px rgba(0, 0, 0, .28); }
        .cheer-button:active { transform: translateY(4px); box-shadow: 0 3px 0 #568fa4; }
        .cheer-button:focus-visible { outline: 3px solid var(--gold); outline-offset: 5px; }

        .ground {
            position: fixed;
            z-index: 2;
            bottom: -55px;
            left: -5%;
            width: 110%;
            height: clamp(105px, 18vh, 190px);
            border-radius: 50% 50% 0 0 / 34% 34% 0 0;
            background: linear-gradient(#eefaff, #b9ddea);
            box-shadow: 0 -15px 45px rgba(185, 237, 255, .16);
            opacity: .9;
        }

        .gift {
            position: fixed;
            z-index: 4;
            right: clamp(18px, 7vw, 100px);
            bottom: clamp(25px, 7vh, 80px);
            font-size: clamp(42px, 7vw, 78px);
            filter: drop-shadow(0 10px 10px rgba(0, 0, 0, .3));
            transform: rotate(7deg);
            animation: gift 3.5s ease-in-out infinite;
        }

        @keyframes aurora { to { transform: translateX(8%) scale(1.12); opacity: .75; } }
        @keyframes twinkle { to { opacity: .74; } }
        @keyframes arrive { from { opacity: 0; transform: translateY(38px) scale(.88); } to { opacity: 1; transform: none; } }
        @keyframes cardFloat { 50% { translate: 0 -7px; } }
        @keyframes treeBounce { 50% { transform: translateX(-50%) translateY(-5px) rotate(3deg); } }
        @keyframes gift { 50% { transform: rotate(-5deg) translateY(-7px); } }
        @keyframes swing { from { transform: rotate(-3deg); } to { transform: rotate(3deg); } }

        @keyframes snowfall {
            from { transform: translate3d(0, -5vh, 0) rotate(0deg); }
            to { transform: translate3d(var(--drift), 108vh, 0) rotate(360deg); }
        }

        @media (max-width: 520px) {
            .countdown { gap: 6px; }
            .unit { border-radius: 15px; }
            .ornament { opacity: .65; }
            .gift { opacity: .78; }
        }

        @media (max-height: 650px) {
            .scene { padding-block: 20px; }
            .card { padding-block: 24px 20px; }
            .tree { display: none; }
            .eyebrow { margin-top: 0; }
            .countdown { margin-top: 18px; }
            .status { margin-top: 14px; }
            .cheer-button { margin-top: 14px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; }
            .cheer-button { transition: none; }
        }
    </style>
</head>
<body>
    <div class="aurora" aria-hidden="true"></div>
    <div class="stars" aria-hidden="true"></div>
    <div class="decorations" aria-hidden="true">
        <i class="ornament one"></i>
        <i class="ornament two"></i>
    </div>
    <div class="snow" aria-hidden="true"></div>
    <div class="ground" aria-hidden="true"></div>
    <div class="gift" aria-hidden="true">🎁</div>

    <main class="scene">
        <section class="card" aria-labelledby="christmas-title">
            <div class="tree" aria-hidden="true">🎄</div>
            <p class="eyebrow">❄️ Operatiunea Craciun</p>
            <h1 id="christmas-title">Christmas Countdown<span>rabdarea se testeaza anual</span></h1>

            <div class="countdown" id="countdown" aria-live="polite" aria-label="Timp ramas pana la Craciun">
                <div class="unit"><span class="number" id="days">--</span><span class="label">zile</span></div>
                <div class="unit"><span class="number" id="hours">--</span><span class="label">ore</span></div>
                <div class="unit"><span class="number" id="minutes">--</span><span class="label">minute</span></div>
                <div class="unit"><span class="number" id="seconds">--</span><span class="label">secunde</span></div>
            </div>

            <p class="status" id="status">Mosul isi face incalzirea. <strong>Tu ocupa-te de cozonac.</strong></p>
            <button class="cheer-button" id="snow-button" type="button">Mai multa zapada! ☃️</button>
        </section>
    </main>

    <script>
        (() => {
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const snow = document.querySelector('.snow');
            const daysNode = document.getElementById('days');
            const hoursNode = document.getElementById('hours');
            const minutesNode = document.getElementById('minutes');
            const secondsNode = document.getElementById('seconds');
            const statusNode = document.getElementById('status');

            const pad = value => String(value).padStart(2, '0');

            const updateCountdown = () => {
                const now = new Date();
                let christmas = new Date(now.getFullYear(), 11, 25, 0, 0, 0);

                if (now.getMonth() === 11 && now.getDate() === 25) {
                    daysNode.textContent = '🎄';
                    hoursNode.textContent = '🎅';
                    minutesNode.textContent = '🎁';
                    secondsNode.textContent = '✨';
                    statusNode.innerHTML = '<strong>Este Craciunul!</strong> Oficial ai voie sa mananci cozonac la orice ora.';
                    return;
                }

                if (now > christmas) christmas = new Date(now.getFullYear() + 1, 11, 25, 0, 0, 0);

                const difference = christmas - now;
                daysNode.textContent = Math.floor(difference / 86400000);
                hoursNode.textContent = pad(Math.floor(difference / 3600000) % 24);
                minutesNode.textContent = pad(Math.floor(difference / 60000) % 60);
                secondsNode.textContent = pad(Math.floor(difference / 1000) % 60);
            };

            const addSnowflake = (burst = false) => {
                const flake = document.createElement('span');
                flake.className = 'snowflake';
                flake.textContent = Math.random() > .7 ? '❄' : '•';
                flake.style.left = `${Math.random() * 100}%`;
                flake.style.fontSize = `${5 + Math.random() * 16}px`;
                flake.style.setProperty('--opacity', .3 + Math.random() * .7);
                flake.style.setProperty('--duration', `${burst ? 3.5 + Math.random() * 3 : 7 + Math.random() * 8}s`);
                flake.style.setProperty('--delay', burst ? `${Math.random() * -.8}s` : `${Math.random() * -14}s`);
                flake.style.setProperty('--drift', `${-70 + Math.random() * 140}px`);
                snow.appendChild(flake);

                if (burst) flake.addEventListener('animationiteration', () => flake.remove(), { once: true });
            };

            updateCountdown();
            setInterval(updateCountdown, 1000);

            if (!reduceMotion) {
                for (let index = 0; index < 72; index++) addSnowflake();
            }

            document.getElementById('snow-button').addEventListener('click', () => {
                for (let index = 0; index < 55; index++) addSnowflake(true);
            });
        })();
    </script>
</body>
</html>
