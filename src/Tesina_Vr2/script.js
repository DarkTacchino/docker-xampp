// Usiamo l'evento 'load' sulla finestra, che si attiva solo dopo che TUTTO
// (incluse immagini e SVG) è stato caricato. Questo risolve i problemi di timing.
window.addEventListener("load", () => {

    // Funzione per l'animazione
    function setupAnimation() {
        // Controlla se le librerie esistono (caricate da CDN)
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined' || typeof Lenis === 'undefined') {
            console.error("Una o più librerie (GSAP, ScrollTrigger, Lenis) non sono state caricate. Controlla i link CDN nell'HTML.");
            return;
        }

        gsap.registerPlugin(ScrollTrigger);

        const lenis = new Lenis();
        lenis.on("scroll", ScrollTrigger.update);
        gsap.ticker.add((time) => {
            lenis.raf(time * 1000);
        });
        gsap.ticker.lagSmoothing(0);

        const heroImgContainer = document.querySelector(".hero-img-container");
        const heroImgLogo = document.querySelector(".hero-img-logo");
        const heroImgCopy = document.querySelector(".hero-img-copy");
        const fadeOverlay = document.querySelector(".fade-overlay");
        const svgOverlay = document.querySelector(".overlay");
        const overlayCopy = document.querySelector(".overlay-copy h1");
        const logoContainer = document.querySelector(".logo-container");
        const logoMask = document.getElementById("logoMask");

        // FIX: Controllo robusto che l'elemento esista prima di usarlo
        if (!logoMask) {
            console.error("Errore critico: Elemento con id='logoMask' non trovato nell'SVG.");
            return; // Interrompe l'animazione ma non il resto dello script
        }
        
        if (typeof logoData === 'undefined') {
            console.error("Errore critico: variabile 'logoData' non trovata. Controlla che logo.js sia caricato correttamente.");
            return;
        }

        logoMask.setAttribute("d", logoData);

        const logoDimensions = logoContainer.getBoundingClientRect();
        const logoBoundingBox = logoMask.getBBox();

        // Controllo di sicurezza per evitare la divisione per zero
        if (logoBoundingBox.width === 0 || logoBoundingBox.height === 0) {
            console.error("Errore: Dimensioni del logo SVG non valide (0). L'animazione è stata interrotta.");
            return;
        }
        
        const horizontalScaleRatio = logoDimensions.width / logoBoundingBox.width;
        const verticalScaleRatio = logoDimensions.height / logoBoundingBox.height;
        const logoScaleFactor = Math.min(horizontalScaleRatio, verticalScaleRatio);
        const logoHorizontalPosition = logoDimensions.left + (logoDimensions.width - logoBoundingBox.width * logoScaleFactor) / 2 - logoBoundingBox.x * logoScaleFactor;
        const logoVerticalPosition = logoDimensions.top + (logoDimensions.height - logoBoundingBox.height * logoScaleFactor) / 2 - logoBoundingBox.y * logoScaleFactor;

        logoMask.setAttribute(
            "transform",
            `translate(${logoHorizontalPosition}, ${logoVerticalPosition}) scale(${logoScaleFactor})`
        );

        ScrollTrigger.create({
            trigger: ".hero",
            start: "top top",
            end: `+=${window.innerHeight * 5}`,
            pin: true,
            pinSpacing: true,
            scrub: 1,
            onUpdate: (self) => {
                const { progress } = self;
                const fadeOpacity = 1 - progress / 0.15;
                gsap.set([heroImgLogo, heroImgCopy], { opacity: progress <= 0.15 ? fadeOpacity : 0 });

                if (progress <= 0.85) {
                    const normalizedProgress = progress / 0.85;
                    const heroImgContainerScale = 1.5 - 0.5 * normalizedProgress;
                    const initialOverlayScale = 350;
                    const overlayScale = initialOverlayScale * Math.pow(1 / initialOverlayScale, normalizedProgress);
                    gsap.set(heroImgContainer, { scale: heroImgContainerScale });
                    gsap.set(svgOverlay, { scale: overlayScale });
                }

                let fadeOverlayOpacity = 0;
                if (progress >= 0.25) {
                    fadeOverlayOpacity = Math.min(1, (progress - 0.25) / 0.4);
                }
                gsap.set(fadeOverlay, { opacity: fadeOverlayOpacity });

                if (progress >= 0.6 && progress <= 0.85) {
                    const revealProgress = (progress - 0.6) / 0.25;
                    const gradientBottom = 240 - revealProgress * 280;
                    const gradientTop = gradientBottom - 100;
                    const copyScale = 1.25 - 0.25 * revealProgress;

                    gsap.set(overlayCopy, {
                        scale: copyScale,
                        backgroundImage: `linear-gradient(to top, #1d1d1f ${gradientTop}%, transparent ${gradientBottom}%)`,
                    });
                } else if (progress < 0.6) {
                    gsap.set(overlayCopy, { backgroundImage: 'none' });
                }
            },
        });
    }

    // Funzione per la traduzione
    function setupTranslation() {
        const translateButton = document.getElementById('translate-btn');
        if (!translateButton) {
            console.error("Pulsante di traduzione non trovato.");
            return;
        }
        
        const translations = { /* ... le tue traduzioni ... */
            'who_am_i': { 'it': 'Chi Sono', 'en': 'Who Am I' }, 'pcto': { 'it': 'PCTO', 'en': 'PCTO' }, 'hobbies': { 'it': 'Hobby', 'en': 'Hobbies' }, 'who_am_i_title': { 'it': 'Chi Sono', 'en': 'Who Am I' }, 'who_am_i_description': { 'it': `Mi chiamo Luciano Arsene e sono uno studente del 5CM, entusiasta di condividere con voi un po' del mio percorso e delle mie passioni. Sono profondamente appassionato di tecnologia e, come molti di voi, sono sempre alla ricerca di nuove conoscenze e sfide da affrontare. Questo portfolio digitale che ho creato è molto più di una semplice raccolta di lavori: è il racconto della mia crescita, delle mie esperienze e del mio costante desiderio di imparare. Spero che esplorandolo possiate cogliere l'impegno e la curiosità che mi guidano ogni giorno.`, 'en': `My name is Luciano Arsene, and I am a 5CM student, excited to share a bit about my journey and my passions with you. I am deeply passionate about technology and, like many of you, I am always seeking new knowledge and challenges to embrace. This digital portfolio I've created is much more than just a collection of works: it's the story of my growth, my experiences, and my continuous desire to learn. I hope that as you explore it, you'll see the dedication and curiosity that drive me every day.` }, 'pcto_title': { 'it': "Percorso per le Competenze Trasversali e l'Orientamento (PCTO)", 'en': 'Path for Transversal Skills and Orientation (PCTO)' }, 'pcto_period_1_title': { 'it': 'Primo Periodo: Maggio - Giugno', 'en': 'First Period: May - June' }, 'pcto_period_1_text': { 'it': `Il mio percorso PCTO si è svolto in due periodi : dal 21 maggio al 9 giugno e, successivamente, dal 12 al 22 settembre. Ho svolto il tirocinio presso l'azienda Fileni , un'importante realtà italiana del settore alimentare, leader nella produzione di carne e pollame biologici, con sede a Cingoli (MC).`, 'en': `My PCTO journey took place in two periods: from May 21st to June 9th and, subsequently, from September 12th to 22nd. I carried out the internship at Fileni, an important Italian company in the food sector, a leader in the production of organic meat and poultry, based in Cingoli (MC).` }, 'pcto_period_1_details': { 'it': `Sono stato inserito nel reparto assistenza informatica , sotto la supervisione del mio tutor aziendale Massimiliano. Durante il primo periodo, mi sono occupato della configurazione di tre PC destinati a nuovi dipendenti, imparando l'importanza della precisione, della metodologia e del rispetto delle procedure aziendali. Inoltre, ho installato Windows 11 sul mio computer personale, migliorando la mia conoscenza del sistema operativo e delle sue funzionalità. Ho avuto anche l'opportunità di accedere alla sala server , esperienza utile per comprendere come funziona un'infrastruttura informatica in un contesto aziendale reale.`, 'en': `I was assigned to the IT support department, under the supervision of my company tutor Massimiliano. During the first period, I was involved in configuring three PCs for new employees, learning the importance of precision, methodology, and adherence to company procedures. Additionally, I installed Windows 11 on my personal computer, improving my knowledge of the operating system and its functionalities. I also had the opportunity to access the server room, a useful experience to understand how an IT infrastructure works in a real corporate context.` }, 'pcto_period_2_title': { 'it': 'Secondo Periodo: Settembre', 'en': 'Second Period: September' }, 'pcto_period_2_text': { 'it': `Nel secondo periodo, le mie attività si sono concentrate maggiormente sul lavoro con i database. In particolare, ho utilizzato SQL per creare e gestire un database di prova, esercitandomi in vista delle attività scolastiche. Questo mi ha permesso di unire la teoria appresa in classe con un contesto pratico, rendendo più chiaro il valore della gestione dei dati nel mondo del lavoro.`, 'en': `In the second period, my activities focused more on working with databases. Specifically, I used SQL to create and manage a test database, practicing in view of school activities. This allowed me to combine theory learned in class with a practical context, making the value of data management in the workplace clearer.` }, 'personal_notes_title': { 'it': 'Osservazioni Personali e Difficoltà', 'en': 'Personal Observations and Difficulties' }, 'personal_notes_text': { 'it': `L'esperienza è stata molto formativa sia dal punto di vista tecnico che personale. Ho potuto osservare da vicino il funzionamento di un'azienda strutturata e conoscere il lavoro di squadra, l'importanza della puntualità, della comunicazione e dell'adattamento. Tuttavia, ho incontrato alcune difficoltà logistiche... Nonostante le piccole difficoltà, considero il mio PCTO estremamente positivo.`, 'en': `The experience was very formative both from a technical and personal point of view. I was able to observe closely the functioning of a structured company and learn about teamwork, the importance of punctuality, communication, and adaptability. However, I encountered some logistical difficulties... Despite the minor difficulties, I consider my PCTO extremely positive.` }, 'hobbies_title': { 'it': 'I Miei Hobby', 'en': 'My Hobbies' }, 'tech_hobby_title': { 'it': 'Tecnologia', 'en': 'Technology' }, 'tech_hobby_text': { 'it': "Sono affascinato dal mondo della tecnologia, dalle ultime innovazioni software e hardware all'intelligenza artificiale e allo sviluppo web.", 'en': 'I am fascinated by the world of technology, from the latest software and hardware innovations to artificial intelligence and web development.' }, 'cars_hobby_title': { 'it': 'Macchine', 'en': 'Cars' }, 'cars_hobby_text': { 'it': 'Ho una grande passione per le automobili, il loro design, la loro ingegneria e le prestazioni. Mi piace mantenermi aggiornato sulle novità del settore.', 'en': 'I have a great passion for cars, their design, engineering, and performance. I like to stay updated on industry news.' }, 'sport_hobby_title': { 'it': 'Sport', 'en': 'Sport' }, 'sport_hobby_text': { 'it': "Lo sport è una parte importante della mia vita, mi aiuta a mantenermi in forma e a scaricare lo stress. Apprezzo sia la pratica che l'osservazione di diverse discipline.", 'en': 'Sport is an important part of my life; it helps me stay in shape and relieve stress. I appreciate both practicing and observing various disciplines.' }, 'footer_text': { 'it': '© 2025 Luciano Arsene. Tutti i diritti riservati.', 'en': '© 2025 Luciano Arsene. All rights reserved.' }
        };

        function updateContent(lang) {
            document.querySelectorAll('[data-translate]').forEach(element => {
                const key = element.getAttribute('data-translate');
                if (translations[key] && translations[key][lang]) {
                    element.innerHTML = translations[key][lang];
                }
            });
        }
        const initialLang = document.documentElement.lang || 'it';
        updateContent(initialLang);
        translateButton.textContent = initialLang === 'en' ? 'EN / IT' : 'IT / EN';
        translateButton.setAttribute('data-lang', initialLang);

        translateButton.addEventListener('click', function() {
            const currentLang = document.documentElement.lang;
            const newLang = currentLang === 'it' ? 'en' : 'it';
            document.documentElement.lang = newLang;
            translateButton.setAttribute('data-lang', newLang);
            translateButton.textContent = newLang === 'en' ? 'EN / IT' : 'IT / EN';
            updateContent(newLang);
        });
    }

    // Esegui entrambe le funzioni principali
    setupAnimation();
    setupTranslation();
});