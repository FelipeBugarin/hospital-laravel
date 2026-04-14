<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-800 leading-tight uppercase tracking-tighter">
                📺 Painel de Atendimento em Tempo Real
            </h2>
            <!-- Player de Música -->
            <div class="bg-white p-2 rounded-xl shadow-inner border flex items-center gap-3">
                <span class="text-[10px] font-black text-gray-400 uppercase">Som Ambiente:</span>
                <audio id="player" controls class="h-8">
                    <source src="{{ asset('audio/painel.mp3') }}" type="audio/mpeg">
                </audio>
            </div>
        </div>
    </x-slot>

    <style>
        /* O "container" do card mantém a posição */
        .card-container {
            perspective: 1000px;
            position: relative;
        }

        /* O card propriamente dito com o chanfro gamer */
        .gamer-card {
            clip-path: polygon(0% 15%, 15% 0%, 100% 0%, 100% 85%, 85% 100%, 0% 100%);
            transition: transform 0.4s cubic-bezier(0.23, 1, 0.32, 1), filter 0.2s;
            position: relative;
            z-index: 1;
        }

        /* Rastro do corte: fino nas pontas e brilhante no centro */
        .slash-trace {
            position: absolute;
            height: 2px; /* Mais fino para ser elegante */
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(255,255,255,1) 50%, 
                transparent 100%);
            box-shadow: 0 0 15px #00f2ff, 0 0 5px #fff;
            z-index: 100;
            pointer-events: none;
            width: 200%; /* Longo para atravessar o card */
            opacity: 0;
        }

        @keyframes slash-action {
            0% { transform: translate(-100%, 0) scaleX(0.1); opacity: 0; }
            20% { opacity: 1; transform: translate(-20%, 0) scaleX(1); }
            100% { transform: translate(50%, 0) scaleX(0.5); opacity: 0; }
        }

        .slash-active {
            animation: slash-action 0.25s cubic-bezier(0.1, 0.7, 1, 0.1) forwards;
        }

        /* Efeito de vibração rápida ao ser cortado */
        @keyframes impact-shake {
            0% { transform: translate(0); }
            25% { transform: translate(5px, -5px); }
            50% { transform: translate(-5px, 5px); }
            75% { transform: translate(5px, 5px); }
            100% { transform: translate(0); }
        }
        .impact { animation: impact-shake 0.15s ease-in-out; }
        
        /* O Container do rastro (responsável por girar e posicionar) */
    .slash-container {
        position: absolute;
        width: 200%; /* Bem largo para cruzar o card */
        height: 2px;
        pointer-events: none;
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* O rastro propriamente dito (responsável pelo movimento de deslize) */
    .slash-line {
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, #fff, #00f2ff, #fff, transparent);
        box-shadow: 0 0 15px #00f2ff;
        filter: blur(1px);
        transform: scaleX(0); /* Começa encolhido */
    }

    @keyframes slash-anim {
        0% { transform: translateX(-100%) scaleX(0.1); opacity: 0; }
        20% { opacity: 1; transform: translateX(-20%) scaleX(1); }
        100% { transform: translateX(100%) scaleX(0.1); opacity: 0; }
    }

    .animate-slash {
        animation: slash-anim 0.25s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    /* Filtro de vidro (Glassmorphism) */
    .glass-impact {
        backdrop-filter: blur(5px);
        background: rgba(255, 255, 255, 0.05) !important;
        transition: all 0.2s ease;
    }

    /* O container das rachaduras */
    .cracks-container {
        position: absolute;
        inset: 0;
        pointer-events: none;
        z-index: 50;
        opacity: 0.8;
    }

    /* Efeito de flash quando o vidro quebra de vez */
    @keyframes glass-shatter {
        0% { filter: brightness(5) white-around; opacity: 1; }
        100% { filter: brightness(1); opacity: 0; }
    }
    .shatter-flash {
        animation: glass-shatter 0.5s ease-out;
    }

    /* Animação de queda com rotação (estilhaço) */
    @keyframes fall-and-fade {
        0% { transform: translateY(0) rotate(0deg); opacity: 1; }
        100% { transform: translateY(1000px) rotate(720deg); opacity: 0; }
    }

    .fragmento-vidro {
        position: absolute;
        pointer-events: none;
        z-index: 200;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255,255,255,0.5);
        clip-path: polygon(50% 0%, 100% 100%, 0% 100%); /* Formato triangular de caco */
        animation: fall-and-fade 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
    }

    /* Efeito de renascimento suave */
    .fade-in-card {
        animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.8); filter: brightness(2); }
        to { opacity: 1; transform: scale(1); filter: brightness(1); }
    }
    </style>

    <!-- Som de corte oculto -->
    <audio id="somCorte" preload="auto">
        <source src="{{ asset('audio/corte.wav') }}" type="audio/wav">
    </audio>

    <!-- Áudio do Boss Oculto -->
    <audio id="audioBoss" preload="auto" loop>
        <source src="{{ asset('audio/painelboss.mp3') }}" type="audio/mpeg">
    </audio>

    <!-- Vídeo de Fundo do Boss -->
    <video id="videoBoss" loop muted playsinline class="fixed inset-0 w-full h-full object-cover z-[-1] opacity-0 transition-opacity duration-[2000ms]">
        <source src="{{ asset('videos/boss.mp4') }}" type="video/mp4">
    </video>

    <!-- Botão de Reset de Emergência -->
    <div id="btnResetBoss" class="fixed bottom-10 left-1/2 -translate-x-1/2 z-[100] hidden">
        <button onclick="resetarIlusao()" class="bg-red-600 hover:bg-red-700 text-white font-black py-4 px-8 rounded-full shadow-[0_0_20px_#ff0000] uppercase tracking-widest transition-all hover:scale-110 active:scale-95">
            🚫 Me tire dessa ilusão
        </button>
    </div>

    <div id="painelPrincipal" class="py-12 bg-black min-h-screen font-mono transition-colors duration-1000">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($agendamentos as $a)
                    <div data-id="{{ $a->id }}" onclick="efeitoCorte(event, this)" 
                        class="gamer-card neon-border bg-gray-900 cursor-pointer relative group overflow-hidden p-6 mb-4">
                        
                        <!-- Linhas de Scanner de fundo -->
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-blue-500/5 to-transparent h-2 w-full animate-scan"></div>

                        <div class="flex">
                            <div class="bg-blue-600/20 p-8 flex flex-col justify-center items-center border-r border-blue-500/30">
                                <span class="text-4xl font-black text-cyan-400 drop-shadow-[0_0_10px_rgba(0,242,255,0.8)]">
                                    {{ $a->data_prevista->format('H:i') }}
                                </span>
                            </div>
                            
                            <div class="p-8 flex-1">
                                <h3 class="text-[10px] font-black text-purple-500 uppercase tracking-[0.3em] mb-1">
                                    [ SECTOR: {{ $a->exame->nome ?? 'MED-BAY' }} ]
                                </h3>
                                <h2 class="text-4xl font-black text-white mb-2 uppercase italic tracking-tighter group-hover:translate-x-2 transition-transform">
                                    {{ $a->paciente->nome }}
                                </h2>
                                <p class="text-sm text-cyan-300/60 font-bold uppercase">
                                    >> RESPONSÁVEL: DR. {{ $a->medico->nome }}
                                </p>
                            </div>
                        </div>

                        <!-- Decoração Gamer nas quinas -->
                        <div class="absolute bottom-0 right-0 w-8 h-8 bg-cyan-500 rotate-45 translate-x-4 translate-y-4"></div>
                    </div>
                @empty
                    <!-- Mensagem Vazia -->
                @endforelse
            </div>
        </div>
    </div>

    <!-- Script para tocar o som ao carregar se houver novos itens -->
    @push('scripts')
    <script>
        // Dica: Para o autoplay funcionar, o usuário precisa interagir com a página ao menos uma vez
        console.log("Painel carregado com sucesso.");
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const player = document.getElementById('player');

        // Tenta tocar assim que a página carrega
        let playPromise = player.play();

        if (playPromise !== undefined) {
            playPromise.then(_ => {
                // Autoplay funcionou!
                console.log("Autoplay liberado!");
            }).catch(error => {
                // Autoplay bloqueado - precisamos de um clique
                console.log("Autoplay bloqueado pelo navegador. Aguardando interação...");
                
                // Adiciona um evento que toca a música no primeiro clique na tela
                document.addEventListener('click', function() {
                    player.play();
                }, { once: true }); // O 'once: true' faz o evento rodar só uma vez
            });
        }
    });
</script>

<script>
    const danosPorCard = {};
    let totalQuebras = 0; 
    let bossAtivo = false;

    function crossfade(fadeOutAudio, fadeInAudio) {
        const duracao = 2000; 
        const intervalo = 50; 
        const passoVolume = intervalo / duracao;
        fadeInAudio.volume = 0;
        fadeInAudio.play();
        const timer = setInterval(() => {
            if (fadeOutAudio.volume > 0) fadeOutAudio.volume = Math.max(0, fadeOutAudio.volume - passoVolume);
            if (fadeInAudio.volume < 1) fadeInAudio.volume = Math.min(1, fadeInAudio.volume + passoVolume);
            if (fadeOutAudio.volume === 0 && fadeInAudio.volume === 1) {
                fadeOutAudio.pause();
                clearInterval(timer);
            }
        }, intervalo);
    }

    function efeitoCorte(event, elemento) {
        const cardId = elemento.getAttribute('data-id') || elemento.innerText.substring(0, 10);
        if (!danosPorCard[cardId]) danosPorCard[cardId] = 0;
        
        danosPorCard[cardId]++;
        const limiteDano = 6;

        // 1. Sons e Impacto (Acontece em TODO clique)
        const somCorte = document.getElementById('somCorte');
        somCorte.currentTime = 0;
        somCorte.play();

        const angulo = Math.floor(Math.random() * 360);
        const rect = elemento.getBoundingClientRect();
        const forca = 25;
        const moveX = Math.cos((angulo + 180) * Math.PI / 180) * forca;
        const moveY = Math.sin((angulo + 180) * Math.PI / 180) * forca;

        elemento.style.transition = "none";
        elemento.style.transform = `translate(${moveX}px, ${moveY}px) scale(0.96) rotate(${moveX/4}deg)`;
        elemento.style.filter = "brightness(2) saturate(2)";

        // 2. Rastro de Luz (Slash)
        const container = document.createElement('div');
        container.className = 'slash-container';
        container.style.left = (event.clientX - rect.left - rect.width) + "px"; 
        container.style.top = (event.clientY - rect.top) + "px";
        container.style.transform = `rotate(${angulo}deg)`;
        const line = document.createElement('div');
        line.className = 'slash-line animate-slash';
        container.appendChild(line);
        elemento.appendChild(container);

        // 3. Rachadura Visual
        const crack = document.createElement('div');
        crack.style.position = 'absolute';
        crack.style.left = (event.clientX - rect.left) + 'px';
        crack.style.top = (event.clientY - rect.top) + 'px';
        crack.style.width = '2px';
        crack.style.height = '100px';
        crack.style.background = 'rgba(255,255,255,0.4)';
        crack.style.boxShadow = '0 0 10px white';
        crack.style.transform = `rotate(${Math.random() * 360}deg)`;
        crack.style.pointerEvents = 'none';
        crack.className = 'rachadura-visual';
        elemento.appendChild(crack);

        // 4. Lógica de QUEBRA (Quando atinge o limite)
        if (danosPorCard[cardId] >= limiteDano) {
            totalQuebras++;
            const somQuebra = new Audio("{{ asset('audio/glass.mp3') }}");
            somQuebra.play();

            // Criar Estilhaços
            for (let i = 0; i < 12; i++) {
                const caco = document.createElement('div');
                caco.className = 'fragmento-vidro';
                caco.style.width = (Math.random() * 50 + 20) + 'px';
                caco.style.height = (Math.random() * 50 + 20) + 'px';
                caco.style.left = (rect.left + Math.random() * rect.width) + 'px';
                caco.style.top = (rect.top + Math.random() * rect.height) + 'px';
                document.body.appendChild(caco);
                setTimeout(() => caco.remove(), 1500);
            }

            elemento.style.opacity = "0";
            setTimeout(() => {
                elemento.querySelectorAll('.rachadura-visual').forEach(el => el.remove());
                danosPorCard[cardId] = 0;
                elemento.classList.add('fade-in-card');
                elemento.style.opacity = "1";
                elemento.style.transform = "translate(0,0) scale(1)";
                setTimeout(() => elemento.classList.remove('fade-in-card'), 800);
            }, 600);

            // VERIFICAÇÃO DO BOSS (3 QUEBRAS NO PAINEL)
            if (totalQuebras === 3 && !bossAtivo) {
                bossAtivo = true;
                const musicaAmbiente = document.getElementById('player');
                const musicaBoss = document.getElementById('audioBoss');
                const video = document.getElementById('videoBoss');
                const btnReset = document.getElementById('btnResetBoss');
                const painel = document.getElementById('painelPrincipal');

                // 1. Inicia o Crossfade
                crossfade(musicaAmbiente, musicaBoss);

                // 2. Ativa o Vídeo
                video.play(); // Força o play do vídeo
                video.style.zIndex = "0"; // Traz para a frente do fundo mas atrás dos cards
                video.classList.remove('opacity-0');
                video.classList.add('opacity-100');

                // 3. Torna o fundo do painel transparente para o vídeo aparecer atrás
                painel.style.backgroundColor = "transparent";
                
                // 4. Mostra o botão de reset
                btnReset.classList.remove('hidden');

                Swal.fire({
                    title: '🚨 PROTOCOLO BOSS ATIVADO',
                    text: 'A realidade foi distorcida!',
                    icon: 'warning',
                    background: '#000',
                    color: '#ff0000',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        } else {
            // Retorno suave se não quebrar
            setTimeout(() => {
                elemento.style.transition = "all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)";
                elemento.style.transform = "translate(0, 0) scale(1) rotate(0deg)";
                elemento.style.filter = "none";
                setTimeout(() => container.remove(), 300);
            }, 100);
        }
    }
    
    // NOVA FUNÇÃO: Resetar tudo para o normal
        function resetarIlusao() {
        const musicaAmbiente = document.getElementById('player');
        const musicaBoss = document.getElementById('audioBoss');
        const video = document.getElementById('videoBoss');
        const btnReset = document.getElementById('btnResetBoss');
        const painel = document.getElementById('painelPrincipal'); // Pegamos o painel novamente

        // 1. Inverte o Crossfade
        crossfade(musicaBoss, musicaAmbiente);

        // 2. Esconde o vídeo (Muda opacidade e joga para trás de tudo)
        video.classList.add('opacity-0');
        video.classList.remove('opacity-100');
        
        setTimeout(() => {
            video.pause();
            video.style.zIndex = "-1"; // Joga o vídeo para trás da "parede" preta
        }, 2000); // Espera o tempo do fade-out do vídeo

        // 3. Traz o fundo preto original do painel de volta
        painel.style.backgroundColor = "black";
        
        // 4. Esconde o botão de reset
        btnReset.classList.add('hidden');
        
        // 5. Reseta o estado global
        bossAtivo = false;
        totalQuebras = 0;

        Swal.fire({
            title: 'REALIDADE RESTAURADA',
            text: 'O sistema voltou à estabilidade.',
            icon: 'success',
            background: '#111',
            color: '#00f2ff',
            timer: 2000,
            showConfirmButton: false
        });
    }
</script>


    @endpush
</x-app-layout>
