<!doctype html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#100828">
    <title>La multi ani! 🎉</title>
    <style>
        :root {
            color-scheme: dark;
            --cream: #fff8df;
            --pink: #ff5fa2;
            --yellow: #ffd85a;
            --purple: #a876ff;
            --cyan: #5ee7f2;
        }

        * { box-sizing: border-box; }

        html, body { width: 100%; min-height: 100%; margin: 0; }

        body {
            min-height: 100svh;
            overflow: hidden;
            font-family: "Trebuchet MS", "Arial Rounded MT Bold", system-ui, sans-serif;
            background:
                radial-gradient(circle at 50% 110%, rgba(255, 95, 162, .28), transparent 42%),
                radial-gradient(circle at 10% 10%, rgba(94, 231, 242, .13), transparent 30%),
                linear-gradient(145deg, #09041a 0%, #1c0a38 48%, #100828 100%);
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            opacity: .24;
            background-image:
                radial-gradient(circle, #fff 0 1px, transparent 1.5px),
                radial-gradient(circle, #fff 0 1px, transparent 1.5px);
            background-position: 0 0, 34px 57px;
            background-size: 82px 82px, 113px 113px;
            animation: stars 8s ease-in-out infinite alternate;
        }

        #fireworks, .kisses, .confetti {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        #fireworks { z-index: 1; }
        .confetti { z-index: 2; overflow: hidden; }
        .kisses { z-index: 3; overflow: hidden; }

        .stage {
            position: relative;
            z-index: 4;
            min-height: 100svh;
            display: grid;
            place-items: center;
            padding: max(24px, env(safe-area-inset-top)) 18px max(24px, env(safe-area-inset-bottom));
            isolation: isolate;
        }

        .card {
            position: relative;
            width: min(680px, 92vw);
            padding: clamp(28px, 6vw, 56px) clamp(22px, 7vw, 62px) clamp(26px, 5vw, 44px);
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: clamp(28px, 6vw, 48px);
            text-align: center;
            background: linear-gradient(145deg, rgba(38, 16, 73, .82), rgba(17, 8, 39, .9));
            box-shadow:
                0 30px 90px rgba(0, 0, 0, .42),
                inset 0 1px 0 rgba(255, 255, 255, .16),
                0 0 80px rgba(168, 118, 255, .13);
            backdrop-filter: blur(12px);
            animation: entrance .9s cubic-bezier(.2, .9, .2, 1.15) both, float 5s 1s ease-in-out infinite;
        }

        .card::before {
            content: "";
            position: absolute;
            inset: -2px;
            z-index: -1;
            border-radius: inherit;
            background: linear-gradient(120deg, var(--yellow), var(--pink), var(--purple), var(--cyan));
            opacity: .42;
            filter: blur(12px);
        }

        .crown {
            position: absolute;
            top: -31px;
            left: 50%;
            font-size: clamp(48px, 9vw, 70px);
            filter: drop-shadow(0 8px 12px rgba(0, 0, 0, .35));
            transform: translateX(-50%) rotate(-7deg);
            animation: crown 2.2s ease-in-out infinite;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 5px 0 13px;
            padding: 7px 13px;
            border: 1px solid rgba(255, 216, 90, .35);
            border-radius: 999px;
            color: var(--yellow);
            background: rgba(255, 216, 90, .09);
            font-size: clamp(.72rem, 2.6vw, .84rem);
            font-weight: 800;
            letter-spacing: .13em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            color: var(--cream);
            font-size: clamp(2.65rem, 9vw, 5.6rem);
            line-height: .92;
            letter-spacing: -.065em;
            text-wrap: balance;
            text-shadow: 0 5px 0 rgba(105, 42, 134, .8), 0 10px 30px rgba(255, 95, 162, .35);
        }

        h1 span {
            display: block;
            color: var(--pink);
            font-size: .48em;
            line-height: 1.35;
            letter-spacing: .04em;
            text-shadow: none;
        }

        .message {
            max-width: 540px;
            margin: clamp(20px, 4vw, 30px) auto 0;
            color: rgba(255, 248, 223, .92);
            font-size: clamp(1.08rem, 3.8vw, 1.48rem);
            font-weight: 650;
            line-height: 1.55;
            text-wrap: balance;
        }

        .signature {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 18px;
            color: var(--pink);
            font-size: clamp(1.25rem, 4.5vw, 1.7rem);
            font-weight: 900;
        }

        .signature span { animation: kissPulse 1.4s ease-in-out infinite; }

        .button {
            appearance: none;
            margin-top: 24px;
            padding: 12px 19px;
            border: 0;
            border-radius: 999px;
            color: #24102c;
            background: linear-gradient(135deg, var(--yellow), #ff9f68);
            box-shadow: 0 8px 0 #a94064, 0 14px 25px rgba(0, 0, 0, .25);
            font: inherit;
            font-size: .92rem;
            font-weight: 900;
            cursor: pointer;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .button:hover { transform: translateY(-2px) rotate(-1deg); box-shadow: 0 10px 0 #a94064, 0 18px 28px rgba(0, 0, 0, .28); }
        .button:active { transform: translateY(5px); box-shadow: 0 3px 0 #a94064; }
        .button:focus-visible { outline: 3px solid white; outline-offset: 5px; }

        .fine-print {
            margin: 19px 0 0;
            color: rgba(255, 255, 255, .48);
            font-size: .72rem;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .kiss {
            position: absolute;
            bottom: -70px;
            opacity: 0;
            font-size: clamp(25px, 5vw, 48px);
            filter: drop-shadow(0 7px 8px rgba(0, 0, 0, .3));
            animation: kissFly var(--duration) ease-in-out forwards;
        }

        .confetti-piece {
            position: absolute;
            top: -16px;
            width: 8px;
            height: 14px;
            border-radius: 2px;
            background: var(--color);
            animation: confettiFall var(--duration) linear forwards;
        }

        @keyframes entrance {
            from { opacity: 0; transform: translateY(35px) scale(.86) rotate(-2deg); }
            to { opacity: 1; transform: translateY(0) scale(1) rotate(0); }
        }

        @keyframes float {
            0%, 100% { translate: 0 0; }
            50% { translate: 0 -8px; }
        }

        @keyframes crown {
            0%, 100% { transform: translateX(-50%) rotate(-7deg) translateY(0); }
            50% { transform: translateX(-50%) rotate(7deg) translateY(-5px); }
        }

        @keyframes stars { to { opacity: .48; transform: translateY(5px); } }
        @keyframes kissPulse { 50% { transform: scale(1.28) rotate(8deg); } }

        @keyframes kissFly {
            0% { opacity: 0; transform: translate3d(0, 0, 0) rotate(var(--start-rotation)) scale(.5); }
            18% { opacity: .9; }
            82% { opacity: .8; }
            100% { opacity: 0; transform: translate3d(var(--drift), -115vh, 0) rotate(var(--end-rotation)) scale(1.25); }
        }

        @keyframes confettiFall {
            to { transform: translate3d(var(--drift), 108vh, 0) rotate(800deg); }
        }

        @media (max-height: 620px) {
            .stage { padding-block: 18px; }
            .card { padding-block: 24px 20px; }
            .crown { display: none; }
            .message { margin-top: 14px; line-height: 1.4; }
            .button { margin-top: 15px; }
            .fine-print { margin-top: 13px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; }
            .button { transition: none; }
        }
    </style>
</head>
<body>
    <canvas id="fireworks" aria-hidden="true"></canvas>
    <div class="confetti" aria-hidden="true"></div>
    <div class="kisses" aria-hidden="true"></div>

    <main class="stage">
        <section class="card" aria-labelledby="birthday-title">
            <div class="crown" aria-hidden="true">👑</div>
            <p class="eyebrow">🎂 Nivel nou deblocat</p>
            <h1 id="birthday-title">Hai la multi ani!<span>fratele meu preferat*</span></h1>
            <p class="message">Sa fii sanatos, norocos si sa ai parte doar de lucruri bune!</p>
            <div class="signature">Te pup <span aria-hidden="true">💋</span></div>
            <button class="button" type="button" id="chaos-button">Apasa pentru extra haos 🎉</button>
            <p class="fine-print">* esti singurul, dar tot se pune</p>
        </section>
    </main>

    <script>
        (() => {
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const canvas = document.getElementById('fireworks');
            const context = canvas.getContext('2d');
            const kisses = document.querySelector('.kisses');
            const confetti = document.querySelector('.confetti');
            const colors = ['#ff5fa2', '#ffd85a', '#a876ff', '#5ee7f2', '#ff9568', '#ffffff'];
            let width = 0;
            let height = 0;
            let particles = [];

            const resize = () => {
                const ratio = Math.min(window.devicePixelRatio || 1, 2);
                width = window.innerWidth;
                height = window.innerHeight;
                canvas.width = width * ratio;
                canvas.height = height * ratio;
                context.setTransform(ratio, 0, 0, ratio, 0, 0);
            };

            const burst = (x = Math.random() * width, y = height * (.12 + Math.random() * .48), amount = 46) => {
                const color = colors[Math.floor(Math.random() * colors.length)];
                for (let i = 0; i < amount; i++) {
                    const angle = (Math.PI * 2 * i / amount) + Math.random() * .12;
                    const speed = 1.5 + Math.random() * 4.8;
                    particles.push({
                        x, y,
                        vx: Math.cos(angle) * speed,
                        vy: Math.sin(angle) * speed,
                        life: 1,
                        decay: .011 + Math.random() * .012,
                        color,
                        size: 1.3 + Math.random() * 2.2
                    });
                }
            };

            const draw = () => {
                context.clearRect(0, 0, width, height);
                context.globalCompositeOperation = 'lighter';
                particles = particles.filter(particle => {
                    particle.x += particle.vx;
                    particle.y += particle.vy;
                    particle.vx *= .985;
                    particle.vy = particle.vy * .985 + .025;
                    particle.life -= particle.decay;
                    if (particle.life <= 0) return false;

                    context.globalAlpha = particle.life;
                    context.fillStyle = particle.color;
                    context.beginPath();
                    context.arc(particle.x, particle.y, particle.size * particle.life, 0, Math.PI * 2);
                    context.fill();
                    return true;
                });
                context.globalAlpha = 1;
                requestAnimationFrame(draw);
            };

            const addKiss = (extra = false) => {
                const kiss = document.createElement('span');
                kiss.className = 'kiss';
                kiss.textContent = Math.random() > .22 ? '💋' : '😘';
                kiss.style.left = `${4 + Math.random() * 88}%`;
                kiss.style.setProperty('--duration', `${extra ? 3.2 : 5 + Math.random() * 3}s`);
                kiss.style.setProperty('--drift', `${-90 + Math.random() * 180}px`);
                kiss.style.setProperty('--start-rotation', `${-30 + Math.random() * 60}deg`);
                kiss.style.setProperty('--end-rotation', `${-110 + Math.random() * 220}deg`);
                kisses.appendChild(kiss);
                kiss.addEventListener('animationend', () => kiss.remove());
            };

            const addConfetti = (amount = 38) => {
                for (let i = 0; i < amount; i++) {
                    const piece = document.createElement('i');
                    piece.className = 'confetti-piece';
                    piece.style.left = `${Math.random() * 100}%`;
                    piece.style.setProperty('--color', colors[i % colors.length]);
                    piece.style.setProperty('--duration', `${2.5 + Math.random() * 2.5}s`);
                    piece.style.setProperty('--drift', `${-110 + Math.random() * 220}px`);
                    piece.style.animationDelay = `${Math.random() * .45}s`;
                    confetti.appendChild(piece);
                    piece.addEventListener('animationend', () => piece.remove());
                }
            };

            resize();
            window.addEventListener('resize', resize, { passive: true });

            if (!reduceMotion) {
                draw();
                burst(width * .18, height * .24, 42);
                setTimeout(() => burst(width * .82, height * .2, 48), 450);
                setTimeout(() => burst(width * .5, height * .13, 40), 900);
                setInterval(() => burst(), 1350);
                setInterval(addKiss, 720);
                addConfetti(42);
            }

            document.getElementById('chaos-button').addEventListener('click', () => {
                for (let i = 0; i < 5; i++) {
                    setTimeout(() => burst(Math.random() * width, height * (.1 + Math.random() * .5), 54), i * 130);
                }
                for (let i = 0; i < 12; i++) setTimeout(() => addKiss(true), i * 70);
                addConfetti(90);
            });
        })();
    </script>
</body>
</html>
