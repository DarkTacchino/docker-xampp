document.addEventListener('DOMContentLoaded', function() {
    // Questo codice viene eseguito solo quando tutto il contenuto HTML è stato caricato.

    const translateButton = document.getElementById('translate-btn');
    // Seleziona il pulsante di traduzione tramite il suo ID.

    const translations = {
        // Un oggetto che contiene tutte le traduzioni.
        // Ogni chiave (es. 'who_am_i') corrisponde al valore di 'data-translate' nell'HTML.
        // Ogni chiave ha due proprietà: 'it' per italiano e 'en' per inglese.
        'who_am_i': {
            'it': 'Chi Sono',
            'en': 'Who Am I'
        },
        'pcto': {
            'it': 'PCTO',
            'en': 'PCTO'
        },
        'hobbies': {
            'it': 'Hobby',
            'en': 'Hobbies'
        },
        'welcome_title': {
            'it': 'Benvenuto nel mio Portfolio!',
            'en': 'Welcome to My Portfolio!'
        },
        'welcome_text': {
            'it': 'Esplora il mio percorso e le mie passioni.',
            'en': 'Explore my journey and passions.'
        },
        'who_am_i_title': {
            'it': 'Chi Sono',
            'en': 'Who Am I'
        },
        'who_am_i_description': {
            'it': 'Sono Luciano Arsene, studente del 5CM, appassionato di tecnologia e sempre desideroso di imparare cose nuove. Questo sito è il racconto del mio percorso e delle mie esperienze.',
            'en': 'I am Luciano Arsene, a 5CM student, passionate about technology and always eager to learn new things. This website is the story of my journey and experiences.'
        },
        'pcto_title': {
            'it': 'Percorso per le Competenze Trasversali e l\'Orientamento (PCTO)',
            'en': 'Path for Transversal Skills and Orientation (PCTO)'
        },
        'pcto_period_1_title': {
            'it': 'Primo Periodo: Maggio - Giugno',
            'en': 'First Period: May - June'
        },
        'pcto_period_1_text': {
            'it': 'Il mio percorso PCTO si è svolto in due periodi: dal 21 maggio al 9 giugno e, successivamente, dal 12 al 22 settembre. Ho svolto il tirocinio presso l\'azienda Fileni, un\'importante realtà italiana del settore alimentare, leader nella produzione di carne e pollame biologici, con sede a Cingoli (MC).',
            'en': 'My PCTO journey took place in two periods: from May 21st to June 9th and, subsequently, from September 12th to 22nd. I carried out the internship at Fileni, an important Italian company in the food sector, a leader in the production of organic meat and poultry, based in Cingoli (MC).'
        },
        'pcto_period_1_details': {
            'it': 'Sono stato inserito nel reparto assistenza informatica, sotto la supervisione del mio tutor aziendale Massimiliano. Durante il primo periodo, mi sono occupato della configurazione di tre PC destinati a nuovi dipendenti, imparando l\'importanza della precisione, della metodologia e del rispetto delle procedure aziendali. Inoltre, ho installato Windows 11 sul mio computer personale, migliorando la mia conoscenza del sistema operativo e delle sue funzionalità. Ho avuto anche l\'opportunità di accedere alla sala server, esperienza utile per comprendere come funziona un\'infrastruttura informatica in un contesto aziendale reale.',
            'en': 'I was assigned to the IT support department, under the supervision of my company tutor Massimiliano. During the first period, I was involved in configuring three PCs for new employees, learning the importance of precision, methodology, and adherence to company procedures. Additionally, I installed Windows 11 on my personal computer, improving my knowledge of the operating system and its functionalities. I also had the opportunity to access the server room, a useful experience to understand how an IT infrastructure works in a real corporate context.'
        },
        'pcto_period_2_title': {
            'it': 'Secondo Periodo: Settembre',
            'en': 'Second Period: September'
        },
        'pcto_period_2_text': {
            'it': 'Nel secondo periodo, le mie attività si sono concentrate maggiormente sul lavoro con i database. In particolare, ho utilizzato SQL per creare e gestire un database di prova, esercitandomi in vista delle attività scolastiche. Questo mi ha permesso di unire la teoria appresa in classe con un contesto pratico, rendendo più chiaro il valore della gestione dei dati nel mondo del lavoro.',
            'en': 'In the second period, my activities focused more on working with databases. Specifically, I used SQL to create and manage a test database, practicing in view of school activities. This allowed me to combine theory learned in class with a practical context, making the value of data management in the workplace clearer.'
        },
        'personal_notes_title': {
            'it': 'Osservazioni Personali e Difficoltà',
            'en': 'Personal Observations and Difficulties'
        },
        'personal_notes_text': {
            'it': 'L\'esperienza è stata molto formativa sia dal punto di vista tecnico che personale. Ho potuto osservare da vicino il funzionamento di un\'azienda strutturata e conoscere il lavoro di squadra, l\'importanza della puntualità, della comunicazione e dell\'adattamento. Tuttavia, ho incontrato alcune difficoltà logistiche. Ogni mattina dovevo prendere due corriere per arrivare: una per Cingoli e un\'altra per Jesi, con un\'attesa di circa un\'ora prima dell\'inizio dell\'orario lavorativo. Inoltre, gli odori provenienti dalla zona produttiva, dove si lavora carne e pollo fritto, non erano sempre piacevoli. Nonostante le piccole difficoltà, considero il mio PCTO estremamente positivo. Ho consolidato competenze tecniche apprese a scuola, ne ho acquisite di nuove e ho vissuto un\'esperienza concreta di lavoro. Questo percorso mi ha fatto crescere sia a livello professionale che personale, confermando il mio interesse per il settore informatico e l\'importanza del continuo apprendimento.',
            'en': 'The experience was very formative both from a technical and personal point of view. I was able to observe closely the functioning of a structured company and learn about teamwork, the importance of punctuality, communication, and adaptability. However, I encountered some logistical difficulties. Every morning I had to take two buses to arrive: one for Cingoli and another for Jesi, with a wait of about an hour before the start of working hours. Furthermore, the smells from the production area, where meat and fried chicken are processed, were not always pleasant. Despite the minor difficulties, I consider my PCTO extremely positive. I consolidated technical skills learned at school, acquired new ones, and had a concrete work experience. This journey has made me grow both professionally and personally, confirming my interest in the IT sector and the importance of continuous learning.'
        },
        'hobbies_title': {
            'it': 'I Miei Hobby',
            'en': 'My Hobbies'
        },
        'tech_hobby_title': {
            'it': 'Tecnologia',
            'en': 'Technology'
        },
        'tech_hobby_text': {
            'it': 'Sono affascinato dal mondo della tecnologia, dalle ultime innovazioni software e hardware all\'intelligenza artificiale e allo sviluppo web.',
            'en': 'I am fascinated by the world of technology, from the latest software and hardware innovations to artificial intelligence and web development.'
        },
        'cars_hobby_title': {
            'it': 'Macchine',
            'en': 'Cars'
        },
        'cars_hobby_text': {
            'it': 'Ho una grande passione per le automobili, il loro design, la loro ingegneria e le prestazioni. Mi piace mantenermi aggiornato sulle novità del settore.',
            'en': 'I have a great passion for cars, their design, engineering, and performance. I like to stay updated on industry news.'
        },
        'sport_hobby_title': {
            'it': 'Sport',
            'en': 'Sport'
        },
        'sport_hobby_text': {
            'it': 'Lo sport è una parte importante della mia vita, mi aiuta a mantenermi in forma e a scaricare lo stress. Apprezzo sia la pratica che l\'osservazione di diverse discipline.',
            'en': 'Sport is an important part of my life; it helps me stay in shape and relieve stress. I appreciate both practicing and observing various disciplines.'
        },
        'footer_text': {
            'it': '&copy; 2025 Luciano Arsene. Tutti i diritti riservati.',
            'en': '&copy; 2025 Luciano Arsene. All rights reserved.'
        }
    };

    function updateContent(lang) {
        // Questa funzione scorre tutti gli elementi con l'attributo 'data-translate'
        // e aggiorna il loro testo in base alla lingua selezionata.
        document.querySelectorAll('[data-translate]').forEach(element => {
            const key = element.getAttribute('data-translate');
            if (translations[key] && translations[key][lang]) {
                element.innerHTML = translations[key][lang];
            }
        });
    }

    // Imposta la lingua iniziale del sito in base all'attributo lang dell'HTML.
    // Oppure, se l'HTML ha lang="it" di default, possiamo fare un'inizializzazione.
    const initialLang = document.documentElement.lang;
    updateContent(initialLang); // Assicurati che il contenuto iniziale sia nella lingua corretta.

    // Aggiunge un "ascoltatore di eventi" al pulsante di traduzione.
    // Quando il pulsante viene cliccato, esegue la funzione definita.
    translateButton.addEventListener('click', function() {
        let currentLang = translateButton.getAttribute('data-lang');
        let newLang;

        if (currentLang === 'en') {
            newLang = 'it';
            translateButton.setAttribute('data-lang', 'it');
            translateButton.textContent = 'IT / EN';
            document.documentElement.lang = 'it'; // Aggiorna l'attributo lang dell'HTML
        } else {
            newLang = 'en';
            translateButton.setAttribute('data-lang', 'en');
            translateButton.textContent = 'EN / IT';
            document.documentElement.lang = 'en'; // Aggiorna l'attributo lang dell'HTML
        }
        updateContent(newLang); // Chiama la funzione per aggiornare il testo.
    });
});