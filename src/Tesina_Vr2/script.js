// Assicurati che GSAP, ScrollTrigger e Lenis siano importati o inclusi nel tuo progetto.
// Assicurati anche che la variabile 'logoData' sia disponibile (es. da un file logo.js)
gsap.registerPlugin(ScrollTrigger);

document.addEventListener("DOMContentLoaded", () => {
  
  /**
   * FUNZIONE 1: IMPOSTAZIONE DELL'ANIMAZIONE DI SCROLL
   * Questa funzione gestisce lo smooth scroll con Lenis e l'intera animazione
   * basata su ScrollTrigger per l'effetto hero.
   */
  function setupAnimation() {
    // Imposta lo smooth scroll con Lenis
    const lenis = new Lenis();
    lenis.on("scroll", ScrollTrigger.update);
    gsap.ticker.add((time) => {
      lenis.raf(time * 1000);
    });
    gsap.ticker.lagSmoothing(0);

    // Seleziona tutti gli elementi necessari dal DOM per l'animazione
    const heroImgContainer = document.querySelector(".hero-img-container");
    const heroImgLogo = document.querySelector(".hero-img-logo");
    const heroImgCopy = document.querySelector(".hero-img-copy");
    const fadeOverlay = document.querySelector(".fade-overlay");
    const svgOverlay = document.querySelector(".overlay");
    const overlayCopy = document.querySelector(".overlay-copy h1");
    // NUOVO: Seleziona l'header per l'animazione di apparizione
    const header = document.querySelector("header");

    // Impostazioni iniziali
    const initialOverlayScale = 10050;

    // Setup della maschera SVG con i dati del logo
    const logoContainer = document.querySelector(".logo-container");
    const logoMask = document.getElementById("logoMask");

    // Controlla che gli elementi esistano prima di procedere
    if (!heroImgContainer || !logoContainer || !logoMask || !svgOverlay) {
        console.error("Elementi essenziali per l'animazione non trovati. Controlla le classi CSS e gli ID.");
        return;
    }
    
    // Assicurati che 'logoData' sia disponibile (es. importato da logo.js)
    if (typeof logoData === 'undefined') {
        console.error("La variabile 'logoData' con il path SVG del logo non è definita.");
        return;
    }
    logoMask.setAttribute("d", logoData);

    const logoDimensions = logoContainer.getBoundingClientRect();
    const logoBoundingBox = logoMask.getBBox();
    const horizontalScaleRatio = logoDimensions.width / logoBoundingBox.width;
    const verticalScaleRatio = logoDimensions.height / logoBoundingBox.height;
    const logoScaleFactor = Math.min(horizontalScaleRatio, verticalScaleRatio);
    const logoHorizontalPosition = logoDimensions.left + (logoDimensions.width - logoBoundingBox.width * logoScaleFactor) / 2 - logoBoundingBox.x * logoScaleFactor;
    const logoVerticalPosition = logoDimensions.top + (logoDimensions.height - logoBoundingBox.height * logoScaleFactor) / 2 - logoBoundingBox.y * logoScaleFactor;

    logoMask.setAttribute("transform", `translate(${logoHorizontalPosition}, ${logoVerticalPosition}) scale(${logoScaleFactor})`);

    // Crea l'animazione con ScrollTrigger
    ScrollTrigger.create({
      trigger: ".hero",
      start: "top top",
      end: `${window.innerHeight * 5}px`,
      pin: true,
      pinSpacing: true,
      scrub: 1,
      onUpdate: (self) => {
        const scrollProgress = self.progress;

        // --- BLOCCO 1: Dissolvenza degli elementi iniziali ---
        if (scrollProgress <= 0.15) {
          const fadeOpacity = 1 - scrollProgress * (1 / 0.15);
          gsap.set([heroImgLogo, heroImgCopy], { opacity: fadeOpacity });
        } else {
          gsap.set([heroImgLogo, heroImgCopy], { opacity: 0 });
        }

        // --- BLOCCO 2: Animazione di scaling principale ---
        if (scrollProgress <= 0.85) {
          const normalizedProgress = scrollProgress * (1 / 0.85);
          const heroImgContainerScale = 1.5 - 0.5 * normalizedProgress;
          const overlayScale = initialOverlayScale * Math.pow(1 / initialOverlayScale, normalizedProgress);
          gsap.set(heroImgContainer, { scale: heroImgContainerScale });
          gsap.set(svgOverlay, { scale: overlayScale });
        }

        // --- BLOCCO 3: Dissolvenza dell'overlay bianco ---
        if (scrollProgress >= 0.25) {
          const fadeOverlayOpacity = Math.min(1, (scrollProgress - 0.25) * (1 / 0.4));
          gsap.set(fadeOverlay, { opacity: fadeOverlayOpacity });
        }

        // --- BLOCCO 4: Rivelazione del testo finale con gradiente ---
        if (scrollProgress > 0.6 && scrollProgress <= 0.85) {
          const overlayCopyRevealProgress = (scrollProgress - 0.6) * (1 / 0.25);
          const gradientSpread = 100;
          const gradientBottomPosition = 240 - overlayCopyRevealProgress * 280;
          const gradientTopPosition = gradientBottomPosition - gradientSpread;
          const overlayCopyScale = 1.25 - 0.25 * overlayCopyRevealProgress;

          gsap.set(overlayCopy, {
            opacity: overlayCopyRevealProgress,
            scale: overlayCopyScale,
            backgroundImage: `linear-gradient(to bottom, #111117 0%, #111117 ${gradientTopPosition}%, #e66461 ${gradientBottomPosition}%, #e66461 100%)`,
            backgroundClip: "text",
            webkitBackgroundClip: "text",
            mozBackgroundClip: "text",
            webkitTextFillColor: "transparent",
            mozTextFillColor: "transparent"
          });

        } else if (scrollProgress <= 0.6) {
          gsap.set(overlayCopy, { opacity: 0 });
        }
        
        // --- NUOVO BLOCCO 5: Apparizione graduale della navbar ---
        if (scrollProgress >= 0.5) {
            // Normalizza il progresso da [0.5, 1.0] a [0, 1] per l'opacità
            const navOpacity = (scrollProgress - 0.5) * 2;
            gsap.to(header, { opacity: navOpacity, pointerEvents: 'auto', duration: 0.3 });
        } else {
            gsap.to(header, { opacity: 0, pointerEvents: 'none', duration: 0.3 });
        }
      },
    });
  }
  
  /**
   * FUNZIONE 2: IMPOSTAZIONE DEL SISTEMA DI TRADUZIONE
   * (Questa funzione rimane invariata)
   */
  function setupTranslation() {
    // ... il codice della tua funzione di traduzione rimane identico ...
    const translateButton = document.getElementById('translate-btn');
    if (!translateButton) {
      console.error("Pulsante di traduzione non trovato (ID: 'translate-btn').");
      return;
    }

    const translations = {
      'who_am_i': { 'it': 'Chi Sono', 'en': 'Who Am I' },
      'pcto': { 'it': 'PCTO', 'en': 'PCTO' },
      'hobbies': { 'it': 'Hobby', 'en': 'Hobbies' },
      'who_am_i_title': { 'it': 'Chi Sono', 'en': 'Who Am I' },
      'who_am_i_description': { 'it': `Mi chiamo Luciano Arsene e sono uno studente del 5CM, entusiasta di condividere con voi un po' del mio percorso e delle mie passioni. Sono profondamente appassionato di tecnologia e, come molti di voi, sono sempre alla ricerca di nuove conoscenze e sfide da affrontare. Questo portfolio digitale che ho creato è molto più di una semplice raccolta di lavori: è il racconto della mia crescita, delle mie esperienze e del mio costante desiderio di imparare. Spero che esplorandolo possiate cogliere l'impegno e la curiosità che mi guidano ogni giorno.`, 'en': `My name is Luciano Arsene, and I am a 5CM student, excited to share a bit about my journey and my passions with you. I am deeply passionate about technology and, like many of you, I am always seeking new knowledge and challenges to embrace. This digital portfolio I've created is much more than just a collection of works: it's the story of my growth, my experiences, and my continuous desire to learn. I hope that as you explore it, you'll see the dedication and curiosity that drive me every day.` },
      'pcto_title': { 'it': "Percorso per le Competenze Trasversali e l'Orientamento (PCTO)", 'en': 'Path for Transversal Skills and Orientation (PCTO)' },
      'pcto_period_1_title': { 'it': 'Primo Periodo: Maggio - Giugno', 'en': 'First Period: May - June' },
      'pcto_period_1_text': { 'it': `Il mio percorso PCTO si è svolto in due periodi : dal 21 maggio al 9 giugno e, successivamente, dal 12 al 22 settembre. Ho svolto il tirocinio presso l'azienda Fileni , un'importante realtà italiana del settore alimentare, leader nella produzione di carne e pollame biologici, con sede a Cingoli (MC).`, 'en': `My PCTO journey took place in two periods: from May 21st to June 9th and, subsequently, from September 12th to 22nd. I carried out the internship at Fileni, an important Italian company in the food sector, a leader in the production of organic meat and poultry, based in Cingoli (MC).` },
      'pcto_period_1_details': { 'it': `Sono stato inserito nel reparto assistenza informatica , sotto la supervisione del mio tutor aziendale Massimiliano. Durante il primo periodo, mi sono occupato della configurazione di tre PC destinati a nuovi dipendenti, imparando l'importanza della precisione, della metodologia e del rispetto delle procedure aziendali. Inoltre, ho installato Windows 11 sul mio computer personale, migliorando la mia conoscenza del sistema operativo e delle sue funzionalità. Ho avuto anche l'opportunità di accedere alla sala server , esperienza utile per comprendere come funziona un'infrastruttura informatica in un contesto aziendale reale.`, 'en': `I was assigned to the IT support department, under the supervision of my company tutor Massimiliano. During the first period, I was involved in configuring three PCs for new employees, learning the importance of precision, methodology, and adherence to company procedures. Additionally, I installed Windows 11 on my personal computer, improving my knowledge of the operating system and its functionalities. I also had the opportunity to access the server room, a useful experience to understand how an IT infrastructure works in a real corporate context.` },
      'pcto_period_2_title': { 'it': 'Secondo Periodo: Settembre', 'en': 'Second Period: September' },
      'pcto_period_2_text': { 'it': `Nel secondo periodo, le mie attività si sono concentrate maggiormente sul lavoro con i database. In particolare, ho utilizzato SQL per creare e gestire un database di prova, esercitandomi in vista delle attività scolastiche. Questo mi ha permesso di unire la teoria appresa in classe con un contesto pratico, rendendo più chiaro il valore della gestione dei dati nel mondo del lavoro.`, 'en': `In the second period, my activities focused more on working with databases. Specifically, I used SQL to create and manage a test database, practicing in view of school activities. This allowed me to combine theory learned in class with a practical context, making the value of data management in the workplace clearer.` },
      'personal_notes_title': { 'it': 'Osservazioni Personali e Difficoltà', 'en': 'Personal Observations and Difficulties' },
      'personal_notes_text': { 'it': `L'esperienza è stata molto formativa sia dal punto di vista tecnico che personale. Ho potuto osservare da vicino il funzionamento di un'azienda strutturata e conoscere il lavoro di squadra, l'importanza della puntualità, della comunicazione e dell'adattamento. Tuttavia, ho incontrato alcune difficoltà logistiche... Nonostante le piccole difficoltà, considero il mio PCTO estremamente positivo.`, 'en': `The experience was very formative both from a technical and personal point of view. I was able to observe closely the functioning of a structured company and learn about teamwork, the importance of punctuality, communication, and adaptability. However, I encountered some logistical difficulties... Despite the minor difficulties, I consider my PCTO extremely positive.` },
      'hobbies_title': { 'it': 'I Miei Hobby', 'en': 'My Hobbies' },
      'tech_hobby_title': { 'it': 'Tecnologia', 'en': 'Technology' },
      'tech_hobby_text': { 'it': "Sono affascinato dal mondo della tecnologia, dalle ultime innovazioni software e hardware all'intelligenza artificiale e allo sviluppo web.", 'en': 'I am fascinated by the world of technology, from the latest software and hardware innovations to artificial intelligence and web development.' },
      'cars_hobby_title': { 'it': 'Macchine', 'en': 'Cars' },
      'cars_hobby_text': { 'it': 'Ho una grande passione per le automobili, il loro design, la loro ingegneria e le prestazioni. Mi piace mantenermi aggiornato sulle novità del settore.', 'en': 'I have a great passion for cars, their design, engineering, and performance. I like to stay updated on industry news.' },
      'sport_hobby_title': { 'it': 'Sport', 'en': 'Sport' },
      'sport_hobby_text': { 'it': "Lo sport è una parte importante della mia vita, mi aiuta a mantenermi in forma e a scaricare lo stress. Apprezzo sia la pratica che l'osservazione di diverse discipline.", 'en': 'Sport is an important part of my life; it helps me stay in shape and relieve stress. I appreciate both practicing and observing various disciplines.' },
      'footer_text': { 'it': '© 2025 Luciano Arsene. Tutti i diritti riservati.', 'en': '© 2025 Luciano Arsene. All rights reserved.' }
    };

    function updateContent(lang) {
      document.querySelectorAll('[data-translate]').forEach(element => {
        const key = element.getAttribute('data-translate');
        if (translations[key] && translations[key][lang]) {
          element.innerHTML = translations[key][lang];
        }
      });
      document.documentElement.lang = lang;
      translateButton.textContent = lang === 'en' ? 'EN / IT' : 'IT / EN';
      translateButton.setAttribute('data-lang', lang);
    }
    const initialLang = document.documentElement.lang || 'it';
    updateContent(initialLang);
    translateButton.addEventListener('click', function() {
      const currentLang = document.documentElement.lang;
      const newLang = currentLang === 'it' ? 'en' : 'it';
      updateContent(newLang);
    });
  }

  /**
   * NUOVA FUNZIONE 3: GESTIONE NAVIGAZIONE MOBILE (BURGER MENU)
   * Questa funzione gestisce l'apertura e la chiusura del menu su dispositivi mobili.
   */
  function setupMobileNav() {
    const burgerButton = document.querySelector('.burger-menu');
    const nav = document.querySelector('nav');
    const navLinks = document.querySelectorAll('.nav-links a');

    if (!burgerButton || !nav) {
      console.error("Elementi per il menu burger non trovati.");
      return;
    }

    burgerButton.addEventListener('click', () => {
      nav.classList.toggle('nav-open');
      const isExpanded = nav.classList.contains('nav-open');
      burgerButton.setAttribute('aria-expanded', isExpanded);
    });

    // Chiudi il menu quando si clicca un link (utile per le ancore)
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (nav.classList.contains('nav-open')) {
                nav.classList.remove('nav-open');
                burgerButton.setAttribute('aria-expanded', 'false');
            }
        });
    });
  }


  // --- ESECUZIONE DELLE FUNZIONI PRINCIPALI ---
  setupAnimation();
  setupTranslation();
  setupMobileNav(); // NUOVO: Esegui la funzione per il burger menu
  
});