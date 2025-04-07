<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Il Mio Blog Personale</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        html {
            scroll-behavior: smooth;
            scrollbar-width: none; /* Firefox */
        }
        
        html::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Edge */
        }
        
        body {
            background-color: #000;
            color: #f5f5f7;
            line-height: 1.6;
            overflow-x: hidden;
            -ms-overflow-style: none; /* IE/Edge */
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Scrollbar customization for card descriptions */
        .pcto-description, .hobby-description {
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
            overflow-y: auto;
            max-height: 0;
            opacity: 0;
            transition: all 0.5s ease;
        }
        
        .pcto-description::-webkit-scrollbar, .hobby-description::-webkit-scrollbar {
            display: none; /* Chrome, Safari and Opera */
        }
        
        .pcto-card:hover .pcto-description, .hobby-card:hover .hobby-description {
            max-height: 200px; /* Adjust as needed */
            opacity: 1;
            margin-top: 15px;
        }
        
        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            z-index: 1000;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .nav-logo {
            font-weight: 600;
            font-size: 1.2rem;
            background: linear-gradient(90deg, #a2facf 0%, #64acff 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
        }
        
        .nav-links li {
            margin-left: 30px;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #f5f5f7;
            font-size: 0.95rem;
            font-weight: 400;
            transition: color 0.3s ease;
        }
        
        .nav-links a:hover {
            color: #64acff;
        }
        
        .hamburger {
            display: none;
            cursor: pointer;
            width: 30px;
            height: 20px;
            position: relative;
            z-index: 1001;
        }
        
        .hamburger span {
            display: block;
            position: absolute;
            height: 2px;
            width: 100%;
            background: #f5f5f7;
            border-radius: 2px;
            opacity: 1;
            left: 0;
            transform: rotate(0deg);
            transition: .3s ease-in-out;
        }
        
        .hamburger span:nth-child(1) {
            top: 0px;
        }
        
        .hamburger span:nth-child(2), .hamburger span:nth-child(3) {
            top: 9px;
        }
        
        .hamburger span:nth-child(4) {
            top: 18px;
        }
        
        .hamburger.open span:nth-child(1) {
            top: 9px;
            width: 0%;
            left: 50%;
        }
        
        .hamburger.open span:nth-child(2) {
            transform: rotate(45deg);
        }
        
        .hamburger.open span:nth-child(3) {
            transform: rotate(-45deg);
        }
        
        .hamburger.open span:nth-child(4) {
            top: 9px;
            width: 0%;
            left: 50%;
        }
        
        /* Translate button */
        .translate-btn {
            padding: 8px 15px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 20px;
            color: #f5f5f7;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }
        
        .translate-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        /* Header */
        header {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 20px;
            position: relative;
            background: linear-gradient(180deg, #000 0%, #111 100%);
        }
        
        header h1 {
            font-size: 3.5rem;
            font-weight: 600;
            margin-bottom: 20px;
            background: linear-gradient(90deg, #a2facf 0%, #64acff 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 1.2s ease forwards;
        }
        
        header p {
            font-size: 1.2rem;
            font-weight: 300;
            max-width: 600px;
            margin-bottom: 40px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 1.2s ease forwards 0.3s;
        }
        
        .scroll-indicator {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            animation: fadeIn 1.2s ease forwards 0.9s, bounce 2s infinite 2s;
        }
        
        .scroll-indicator svg {
            width: 32px;
            height: 32px;
            fill: #f5f5f7;
        }
        
        /* Sections */
        section {
            padding: 100px 0;
            position: relative;
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        
        section.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        section h2 {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 60px;
            font-weight: 600;
            background: linear-gradient(90deg, #a2facf 0%, #64acff 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            padding-top: 80px; /* For fixed navbar */
            margin-top: -80px; /* For fixed navbar */
        }
        
        section:nth-child(odd) {
            background-color: #111;
        }
        
        section:nth-child(even) {
            background-color: #0c0c0c;
        }
        
        /* About */
        .profile-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 900px;
            margin: 0 auto;
        }
        
        @media (min-width: 768px) {
            .profile-container {
                flex-direction: row;
                align-items: center;
                gap: 60px;
            }
        }
        
        .profile-image {
            width: 250px;
            height: 250px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #64acff;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(100, 172, 255, 0.2);
            transition: transform 0.5s ease, box-shadow 0.5s ease;
        }
        
        .profile-image:hover {
            transform: scale(1.03);
            box-shadow: 0 15px 40px rgba(100, 172, 255, 0.4);
        }
        
        .profile-text {
            flex: 1;
        }
        
        .profile-text p {
            margin-bottom: 20px;
            font-size: 1.1rem;
            line-height: 1.8;
        }
        
        /* PCTO - Updated Card Style */
        .pcto-container {
            display: flex;
            flex-direction: column;
            gap: 40px;
            max-width: 900px;
            margin: 0 auto;
        }
        
        .pcto-card {
            position: relative;
            height: 280px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            transition: transform 0.5s ease;
        }
        
        .pcto-card:hover {
            transform: translateY(-10px);
        }
        
        .pcto-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-position: center;
            background-size: cover;
            transition: transform 0.5s ease;
            z-index: 1;
        }
        
        .pcto-card:hover .pcto-bg {
            transform: scale(1.1);
        }
        
        .pcto-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.8));
            z-index: 2;
        }
        
        .pcto-content {
            position: relative;
            z-index: 3;
            padding: 30px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .pcto-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #fff;
            margin-bottom: 10px;
            background: linear-gradient(90deg, #a2facf 0%, #64acff 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .pcto-subtitle {
            font-size: 1.1rem;
            color: #ccc;
            margin-bottom: 15px;
        }
        
        .pcto-card ul {
            padding-left: 20px;
        }
        
        .pcto-card li {
            margin-bottom: 8px;
            color: #ddd;
        }
        
        /* Hobbies - Updated Card Style */
        .hobbies-container {
            display: flex;
            flex-direction: column;
            gap: 40px;
            max-width: 900px;
            margin: 0 auto;
        }
        
        .hobby-card {
            position: relative;
            height: 280px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            transition: transform 0.5s ease;
        }
        
        .hobby-card:hover {
            transform: translateY(-10px);
        }
        
        .hobby-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-position: center;
            background-size: cover;
            transition: transform 0.5s ease;
            z-index: 1;
        }
        
        .hobby-card:hover .hobby-bg {
            transform: scale(1.1);
        }
        
        .hobby-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.8));
            z-index: 2;
        }
        
        .hobby-content {
            position: relative;
            z-index: 3;
            padding: 30px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .hobby-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
            background: linear-gradient(90deg, #a2facf 0%, #64acff 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .hobby-icon {
            font-size: 2rem;
            color: #a2facf;
        }
        
        /* BMW Image Styling */
        .car-image-container {
            display: flex;
            justify-content: center;
            margin: 15px 0;
        }
        
        .car-image {
            width: 100%;
            max-width: 280px;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
            transition: transform 0.3s ease;
        }
        
        .car-image:hover {
            transform: scale(1.05);
        }
        
        /* Contact */
        .contact-form {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.03);
            padding: 40px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            color: #f5f5f7;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #64acff;
            box-shadow: 0 0 0 2px rgba(100, 172, 255, 0.2);
        }
        
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        
        .submit-btn {
            background: linear-gradient(90deg, #a2facf 0%, #64acff 100%);
            color: #000;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(100, 172, 255, 0.3);
        }
        
        /* Footer */
        footer {
            background-color: #0c0c0c;
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }
        
        footer p {
            margin: 10px 0;
        }
        
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 25px 0;
        }
        
        .social-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            color: #f5f5f7;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .social-icon:hover {
            background: linear-gradient(90deg, #a2facf 0%, #64acff 100%);
            color: #000;
            transform: translateY(-3px);
        }
        
        /* Animations */
        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateX(-50%) translateY(0);
            }
            40% {
                transform: translateX(-50%) translateY(-10px);
            }
            60% {
                transform: translateX(-50%) translateY(-5px);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
            }
            
            .nav-links {
                position: fixed;
                top: 0;
                left: -100%;
                width: 80%;
                height: 100vh;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                background: rgba(0, 0, 0, 0.95);
                transition: left 0.4s ease;
                z-index: 1000;
            }
            
            .nav-links.active {
                left: 0;
            }
            
            .nav-links li {
                margin: 15px 0;
            }
            
            .nav-links a {
                font-size: 1.2rem;
            }
            
            .hamburger {
                display: block;
            }
            
            header h1 {
                font-size: 2.5rem;
            }
            
            section h2 {
                font-size: 2rem;
                margin-bottom: 40px;
            }
            
            section {
                padding: 70px 0;
            }
            
            .profile-image {
                width: 180px;
                height: 180px;
            }
            
            .pcto-card, .hobby-card {
                height: 320px;
            }
            
            .pcto-card:hover .pcto-description, .hobby-card:hover .hobby-description {
                max-height: 250px; /* More space for mobile */
            }
        }
        
        @media (max-width: 480px) {
            header h1 {
                font-size: 2rem;
            }
            
            header p {
                font-size: 1rem;
            }
            
            .pcto-card, .hobby-card {
                height: 360px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-logo">Luciano Blog</div>
        <ul class="nav-links">
            <li><a href="#about">Chi Sono</a></li>
            <li><a href="#pcto">PCTO</a></li>
            <li><a href="#hobbies">Hobby</a></li>
            <li><a href="#contact">Contatti</a></li>
        </ul>
        <button class="translate-btn">Translate</button>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>
    
    <header>
        <h1>Il Mio Blog Personale</h1>
        <p>Un viaggio attraverso le mie esperienze, passioni e scoperte</p>
        <div class="scroll-indicator">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 17.414L3.293 8.707l1.414-1.414L12 14.586l7.293-7.293 1.414 1.414L12 17.414z"/>
            </svg>
        </div>
    </header>
    
    <section id="about" class="section">
        <div class="container">
            <h2>Chi Sono</h2>
            <div class="profile-container">
                <img src="img/mia_foto.jpg" alt="La mia foto" class="profile-image" onerror="this.src='https://via.placeholder.com/250x250?text=La+Mia+Foto'">
                <div class="profile-text">
                    <p>Ciao! Mi chiamo Luciano Manuel Arsene, ho 18 anni e vengo da Jesi, Italia.</p>
                    <p>Sono uno studente di Informatica presso l'IIS Marconi Pieralisi. Mi interessa particolarmente l'informatica e le tecnologie digitali.</p>
                    <p>La mia ambizione è diventare un professionista nel campo dello sviluppo software, con particolare attenzione al design e all'esperienza utente.</p>
                    <p>Questo blog rappresenta il mio progetto per il corso di Informatica, dove condivido le mie passioni, esperienze e competenze acquisite durante il mio percorso formativo.</p>
                </div>
            </div>
        </div>
    </section>
    
    <section id="pcto" class="section">
        <div class="container">
            <h2>La Mia Esperienza PCTO</h2>
            <div class="pcto-container">
                <div class="pcto-card">
                    <div class="pcto-bg" style="background-image: url('https://images.unsplash.com/photo-1497032628192-86f99bcd76bc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');"></div>
                    <div class="pcto-overlay"></div>
                    <div class="pcto-content">
                        <div>
                            <h3 class="pcto-title">Dove l'ho svolto</h3>
                            <div class="pcto-subtitle">Fileni - Jesi</div>
                        </div>
                        <div class="pcto-description">
                            <p>Ho avuto l'opportunità di svolgere il mio Percorso per le Competenze Trasversali e l'Orientamento presso Fileni a Jesi durante il periodo febbraio-marzo 2023.</p>
                            <p>L'azienda si occupa principalmente della produzione di carni avicole biologiche ed è stata un'ottima palestra per conoscere il mondo del lavoro.</p>
                        </div>
                    </div>
                </div>
                
                <div class="pcto-card">
                    <div class="pcto-bg" style="background-image: url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');"></div>
                    <div class="pcto-overlay"></div>
                    <div class="pcto-content">
                        <div>
                            <h3 class="pcto-title">Cosa ho fatto</h3>
                            <div class="pcto-subtitle">Attività e progetti</div>
                        </div>
                        <div class="pcto-description">
                            <p>Durante questa esperienza ho avuto modo di:</p>
                            <ul>
                                <li>Partecipare attivamente al progetto di digitalizzazione dei processi</li>
                                <li>Collaborare con il team IT e produzione</li>
                                <li>Apprendere l'utilizzo di software gestionali specifici</li>
                                <li>Contribuire all'ottimizzazione dei flussi di lavoro</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="pcto-card">
                    <div class="pcto-bg" style="background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80');"></div>
                    <div class="pcto-overlay"></div>
                    <div class="pcto-content">
                        <div>
                            <h3 class="pcto-title">Cosa ho imparato</h3>
                            <div class="pcto-subtitle">Competenze acquisite</div>
                        </div>
                        <div class="pcto-description">
                            <p>Questa esperienza formativa mi ha permesso di:</p>
                            <ul>
                                <li>Migliorare le mie competenze tecniche in ambienti gestionali</li>
                                <li>Comprendere le dinamiche di un ambiente lavorativo reale</li>
                                <li>Sviluppare capacità di problem solving e time management</li>
                                <li>Imparare a lavorare in team e a comunicare efficacemente</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="pcto-card">
                    <div class="pcto-bg" style="background-image: url('https://images.unsplash.com/photo-1574607383476-f517f260d30b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1472&q=80');"></div>
                    <div class="pcto-overlay"></div>
                    <div class="pcto-content">
                        <div>
                            <h3 class="pcto-title">Difficoltà e soluzioni</h3>
                            <div class="pcto-subtitle">Sfide e crescita personale</div>
                        </div>
                        <div class="pcto-description">
                            <p>Non tutto è stato semplice, ho dovuto affrontare alcune sfide:</p>
                            <ul>
                                <li>Adattarmi a orari e ritmi di lavoro diversi da quelli scolastici</li>
                                <li>Superare difficoltà tecniche con i sistemi informativi aziendali</li>
                                <li>Imparare a gestire lo stress in situazioni di scadenze ravvicinate</li>
                            </ul>
                            <p>Queste difficoltà mi hanno permesso di crescere sia professionalmente che personalmente.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section id="hobbies" class="section">
        <div class="container">
            <h2>I Miei Hobby</h2>
            <div class="hobbies-container">
                <div class="hobby-card">
                    <div class="hobby-bg" style="background-image: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');"></div>
                    <div class="hobby-overlay"></div>
                    <div class="hobby-content">
                        <div>
                            <h3 class="hobby-title"><i class="fas fa-dumbbell hobby-icon"></i>Palestra</h3>
                        </div>
                        <div class="hobby-description">
                            <p>La palestra è diventata parte fondamentale della mia routine quotidiana. Mi alleno regolarmente per mantenermi in forma e migliorare sia la forza che la resistenza. Oltre ai benefici fisici, trovo che l'allenamento mi aiuti a rilassare la mente e a gestire meglio lo stress.</p>
                            <p>Seguo un programma di allenamento che comprende sia esercizi di forza che di resistenza, e mi piace particolarmente l'allenamento funzionale. La disciplina e la costanza che la palestra mi ha insegnato si riflettono positivamente anche nel mio percorso di studi.</p>
                        </div>
                    </div>
                </div>
                
                <div class="hobby-card">
                    <div class="hobby-bg" style="background-image: url('https://images.unsplash.com/photo-1583121274602-3e2820c69888?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');"></div>
                    <div class="hobby-overlay"></div>
                    <div class="hobby-content">
                        <div>
                            <h3 class="hobby-title"><i class="fas fa-car hobby-icon"></i>Macchine</h3>
                        </div>
                        <div class="hobby-description">
                            <p>Sono un appassionato di auto e motori. Mi piace seguire le novità del settore automobilistico, le competizioni e i progressi tecnologici. Ho un particolare interesse per i modelli sportivi e le innovazioni nel campo della mobilità sostenibile e delle auto elettriche.</p>
                            
                            <div class="car-image-container">
                                <img src="https://images.unsplash.com/photo-1580274455191-1c62238fa333?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=764&q=80" alt="BMW M4" class="car-image">
                            </div>
                            
                            <p>Seguo regolarmente le notizie del settore automotive e mi diverto ad approfondire le caratteristiche tecniche dei diversi modelli. Mi piacerebbe in futuro unire questa passione con le mie competenze informatiche, magari lavorando nello sviluppo di software per veicoli connessi.</p>
                        </div>
                    </div>
                </div>
                
                <div class="hobby-card">
                    <div class="hobby-bg" style="background-image: url('https://images.unsplash.com/photo-1550745165-9bc0b252726f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');"></div>
                    <div class="hobby-overlay"></div>
                    <div class="hobby-content">
                        <div>
                            <h3 class="hobby-title"><i class="fas fa-laptop-code hobby-icon"></i>Tecnologia</h3>
                        </div>
                        <div class="hobby-description">
                            <p>La tecnologia non è solo il mio percorso di studi, ma anche una vera passione. Mi piace esplorare nuovi dispositivi, seguire le tendenze tech e sperimentare con la programmazione. Dedico parte del mio tempo libero a progetti personali di coding e allo studio di linguaggi e framework emergenti.</p>
                            <p>Sono particolarmente interessato allo sviluppo web e mobile, all'intelligenza artificiale e alle nuove tecnologie come la realtà aumentata. Seguo diversi blog e canali YouTube dedicati al tech, e partecipo quando possibile a hackathon e eventi del settore per ampliare le mie conoscenze e fare networking.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section id="contact" class="section">
        <div class="container">
            <h2>Contatti</h2>
            <div class="contact-form">
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" id="name" class="form-control" placeholder="Il tuo nome">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" class="form-control" placeholder="La tua email">
                </div>
                <div class="form-group">
                    <label for="message">Messaggio</label>
                    <textarea id="message" class="form-control" placeholder="Scrivi qui il tuo messaggio"></textarea>
                </div>
                <button type="submit" class="submit-btn">Invia Messaggio</button>
            </div>
        </div>
    </section>
    
    <footer>
        <div class="container">
            <div class="social-icons">
                <a href="https://www.iismarconipieralisi.edu.it/" class="social-icon" target="_blank">
                    <i class="fas fa-school"></i>
                </a>
                <a href="https://www.instagram.com/luch__m/" class="social-icon" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.fileni.it" class="social-icon" target="_blank">
                    <i class="fas fa-building"></i>
                </a>
            </div>
            <p>© 2025 Luciano Manuel Arsene – Blog Personale</p>
            <p>Progetto PCTO – Presentazione</p>
        </div>
    </footer>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navbar scroll effect
            const navbar = document.querySelector('.navbar');
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
            
            // Mobile menu toggle
            const hamburger = document.querySelector('.hamburger');
            const navLinks = document.querySelector('.nav-links');
            
            hamburger.addEventListener('click', function() {
                hamburger.classList.toggle('open');
                navLinks.classList.toggle('active');
            });
            
            // Close mobile menu when clicking a link
            document.querySelectorAll('.nav-links a').forEach(link => {
                link.addEventListener('click', () => {
                    hamburger.classList.remove('open');
                    navLinks.classList.remove('active');
                });
            });
            
            // Scroll animation for sections
            const sections = document.querySelectorAll('.section');
            
            function checkVisibility() {
                sections.forEach(section => {
                    const sectionTop = section.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;
                    
                    if (sectionTop < windowHeight * 0.75) {
                        section.classList.add('visible');
                    }
                });
            }
            
            // Initial check
            checkVisibility();
            
            // Check on scroll
            window.addEventListener('scroll', checkVisibility);
            
            // Prevent form submission (to avoid page reload)
            document.querySelector('.contact-form').addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Grazie per il tuo messaggio!');
            });
            
            // Translation functionality
            const translateBtn = document.querySelector('.translate-btn');
            let isItalian = true;
            
            const translations = {
                // Header
                headerTitle: {
                    it: "Il Mio Blog Personale",
                    en: "My Personal Blog"
                },
                headerSubtitle: {
                    it: "Un viaggio attraverso le mie esperienze, passioni e scoperte",
                    en: "A journey through my experiences, passions and discoveries"
                },
                // Navbar
                navAbout: {
                    it: "Chi Sono",
                    en: "About Me"
                },
                navPcto: {
                    it: "PCTO",
                    en: "Internship"
                },
                navHobbies: {
                    it: "Hobby",
                    en: "Hobbies"
                },
                navContact: {
                    it: "Contatti",
                    en: "Contact"
                },
                translateBtn: {
                    it: "Translate",
                    en: "Traduci"
                },
                // About section
                aboutTitle: {
                    it: "Chi Sono",
                    en: "About Me"
                },
                aboutText1: {
                    it: "Ciao! Mi chiamo Luciano Manuel Arsene, ho 18 anni e vengo da Jesi, Italia.",
                    en: "Hi! My name is Luciano Manuel Arsene, I'm 18 years old and I'm from Jesi, Italy."
                },
                aboutText2: {
                    it: "Sono uno studente di Informatica presso l'IIS Marconi Pieralisi. Mi interessa particolarmente l'informatica e le tecnologie digitali.",
                    en: "I'm a Computer Science student at IIS Marconi Pieralisi. I'm particularly interested in computer science and digital technologies."
                },
                aboutText3: {
                    it: "La mia ambizione è diventare un professionista nel campo dello sviluppo software, con particolare attenzione al design e all'esperienza utente.",
                    en: "My ambition is to become a professional in software development, with particular attention to design and user experience."
                },
                aboutText4: {
                    it: "Questo blog rappresenta il mio progetto per il corso di Informatica, dove condivido le mie passioni, esperienze e competenze acquisite durante il mio percorso formativo.",
                    en: "This blog represents my project for the Computer Science course, where I share my passions, experiences and skills acquired during my educational journey."
                },
                // PCTO section
                pctoTitle: {
                    it: "La Mia Esperienza PCTO",
                    en: "My Internship Experience"
                },
                pctoWhere: {
                    it: "Dove l'ho svolto",
                    en: "Where I did it"
                },
                pctoWhereSubtitle: {
                    it: "Fileni - Jesi",
                    en: "Fileni - Jesi"
                },
                pctoWhereText1: {
                    it: "Ho avuto l'opportunità di svolgere il mio Percorso per le Competenze Trasversali e l'Orientamento presso Fileni a Jesi durante il periodo febbraio-marzo 2023.",
                    en: "I had the opportunity to do my Internship at Fileni in Jesi during February-March 2023."
                },
                pctoWhereText2: {
                    it: "L'azienda si occupa principalmente della produzione di carni avicole biologiche ed è stata un'ottima palestra per conoscere il mondo del lavoro.",
                    en: "The company mainly deals with the production of organic poultry meat and was an excellent training ground to get to know the world of work."
                },
                pctoWhat: {
                    it: "Cosa ho fatto",
                    en: "What I did"
                },
                pctoWhatSubtitle: {
                    it: "Attività e progetti",
                    en: "Activities and projects"
                },
                pctoWhatIntro: {
                    it: "Durante questa esperienza ho avuto modo di:",
                    en: "During this experience I had the opportunity to:"
                },
                pctoWhatList1: {
                    it: "Partecipare attivamente al progetto di digitalizzazione dei processi",
                    en: "Actively participate in the process digitization project"
                },
                pctoWhatList2: {
                    it: "Collaborare con il team IT e produzione",
                    en: "Collaborate with the IT and production team"
                },
                pctoWhatList3: {
                    it: "Apprendere l'utilizzo di software gestionali specifici",
                    en: "Learn the use of specific management software"
                },
                pctoWhatList4: {
                    it: "Contribuire all'ottimizzazione dei flussi di lavoro",
                    en: "Contribute to the optimization of workflows"
                },
                pctoLearned: {
                    it: "Cosa ho imparato",
                    en: "What I learned"
                },
                pctoLearnedSubtitle: {
                    it: "Competenze acquisite",
                    en: "Skills acquired"
                },
                pctoLearnedIntro: {
                    it: "Questa esperienza formativa mi ha permesso di:",
                    en: "This training experience allowed me to:"
                },
                pctoLearnedList1: {
                    it: "Migliorare le mie competenze tecniche in ambienti gestionali",
                    en: "Improve my technical skills in management environments"
                },
                pctoLearnedList2: {
                    it: "Comprendere le dinamiche di un ambiente lavorativo reale",
                    en: "Understand the dynamics of a real work environment"
                },
                pctoLearnedList3: {
                    it: "Sviluppare capacità di problem solving e time management",
                    en: "Develop problem solving and time management skills"
                },
                pctoLearnedList4: {
                    it: "Imparare a lavorare in team e a comunicare efficacemente",
                    en: "Learn to work in a team and communicate effectively"
                },
                pctoChallenges: {
                    it: "Difficoltà e soluzioni",
                    en: "Challenges and solutions"
                },
                pctoChallengesSubtitle: {
                    it: "Sfide e crescita personale",
                    en: "Challenges and personal growth"
                },
                pctoChallengesIntro: {
                    it: "Non tutto è stato semplice, ho dovuto affrontare alcune sfide:",
                    en: "Not everything was simple, I had to face some challenges:"
                },
                pctoChallengesList1: {
                    it: "Adattarmi a orari e ritmi di lavoro diversi da quelli scolastici",
                    en: "Adapting to work schedules and rhythms different from school ones"
                },
                pctoChallengesList2: {
                    it: "Superare difficoltà tecniche con i sistemi informativi aziendali",
                    en: "Overcoming technical difficulties with company information systems"
                },
                pctoChallengesList3: {
                    it: "Imparare a gestire lo stress in situazioni di scadenze ravvicinate",
                    en: "Learning to manage stress in situations with tight deadlines"
                },
                pctoChallengesConclusion: {
                    it: "Queste difficoltà mi hanno permesso di crescere sia professionalmente che personalmente.",
                    en: "These difficulties allowed me to grow both professionally and personally."
                },
                // Hobbies section
                hobbiesTitle: {
                    it: "I Miei Hobby",
                    en: "My Hobbies"
                },
                hobbiesGym: {
                    it: "Palestra",
                    en: "Gym"
                },
                hobbiesGymText1: {
                    it: "La palestra è diventata parte fondamentale della mia routine quotidiana. Mi alleno regolarmente per mantenermi in forma e migliorare sia la forza che la resistenza. Oltre ai benefici fisici, trovo che l'allenamento mi aiuti a rilassare la mente e a gestire meglio lo stress.",
                    en: "The gym has become a fundamental part of my daily routine. I train regularly to stay fit and improve both strength and endurance. In addition to the physical benefits, I find that training helps me relax my mind and better manage stress."
                },
                hobbiesGymText2: {
                    it: "Seguo un programma di allenamento che comprende sia esercizi di forza che di resistenza, e mi piace particolarmente l'allenamento funzionale. La disciplina e la costanza che la palestra mi ha insegnato si riflettono positivamente anche nel mio percorso di studi.",
                    en: "I follow a training program that includes both strength and endurance exercises, and I particularly like functional training. The discipline and consistency that the gym has taught me are also positively reflected in my studies."
                },
                hobbiesCars: {
                    it: "Macchine",
                    en: "Cars"
                },
                hobbiesCarsText1: {
                    it: "Sono un appassionato di auto e motori. Mi piace seguire le novità del settore automobilistico, le competizioni e i progressi tecnologici. Ho un particolare interesse per i modelli sportivi e le innovazioni nel campo della mobilità sostenibile e delle auto elettriche.",
                    en: "I am passionate about cars and engines. I like to follow the news in the automotive sector, competitions and technological progress. I have a particular interest in sports models and innovations in the field of sustainable mobility and electric cars."
                },
                hobbiesCarsText2: {
                    it: "Seguo regolarmente le notizie del settore automotive e mi diverto ad approfondire le caratteristiche tecniche dei diversi modelli. Mi piacerebbe in futuro unire questa passione con le mie competenze informatiche, magari lavorando nello sviluppo di software per veicoli connessi.",
                    en: "I regularly follow news from the automotive sector and enjoy learning about the technical characteristics of different models. In the future, I would like to combine this passion with my computer skills, perhaps working in software development for connected vehicles."
                },
                hobbiesTech: {
                    it: "Tecnologia",
                    en: "Technology"
                },
                hobbiesTechText1: {
                    it: "La tecnologia non è solo il mio percorso di studi, ma anche una vera passione. Mi piace esplorare nuovi dispositivi, seguire le tendenze tech e sperimentare con la programmazione. Dedico parte del mio tempo libero a progetti personali di coding e allo studio di linguaggi e framework emergenti.",
                    en: "Technology is not just my course of study, but also a true passion. I like to explore new devices, follow tech trends and experiment with programming. I dedicate part of my free time to personal coding projects and to studying emerging languages and frameworks."
                },
                hobbiesTechText2: {
                    it: "Sono particolarmente interessato allo sviluppo web e mobile, all'intelligenza artificiale e alle nuove tecnologie come la realtà aumentata. Seguo diversi blog e canali YouTube dedicati al tech, e partecipo quando possibile a hackathon e eventi del settore per ampliare le mie conoscenze e fare networking.",
                    en: "I am particularly interested in web and mobile development, artificial intelligence and new technologies such as augmented reality. I follow several blogs and YouTube channels dedicated to tech, and when possible I participate in hackathons and industry events to expand my knowledge and network."
                },
                // Contact section
                contactTitle: {
                    it: "Contatti",
                    en: "Contact Me"
                },
                contactName: {
                    it: "Nome",
                    en: "Name"
                },
                contactNamePlaceholder: {
                    it: "Il tuo nome",
                    en: "Your name"
                },
                contactEmail: {
                    it: "Email",
                    en: "Email"
                },
                contactEmailPlaceholder: {
                    it: "La tua email",
                    en: "Your email"
                },
                contactMessage: {
                    it: "Messaggio",
                    en: "Message"
                },
                contactMessagePlaceholder: {
                    it: "Scrivi qui il tuo messaggio",
                    en: "Write your message here"
                },
                contactButton: {
                    it: "Invia Messaggio",
                    en: "Send Message"
                },
                // Footer
                footerCopyright: {
                    it: "© 2025 Luciano Manuel Arsene – Blog Personale",
                    en: "© 2025 Luciano Manuel Arsene – Personal Blog"
                },
                footerProject: {
                    it: "Progetto PCTO – Presentazione",
                    en: "PCTO Project – Presentation"
                }
            };
            
            translateBtn.addEventListener('click', function() {
                isItalian = !isItalian;
                const lang = isItalian ? 'it' : 'en';
                
                // Update text based on translations
                document.querySelector('header h1').textContent = translations.headerTitle[lang];
                document.querySelector('header p').textContent = translations.headerSubtitle[lang];
                
                // Navbar
                document.querySelectorAll('.nav-links a')[0].textContent = translations.navAbout[lang];
                document.querySelectorAll('.nav-links a')[1].textContent = translations.navPcto[lang];
                document.querySelectorAll('.nav-links a')[2].textContent = translations.navHobbies[lang];
                document.querySelectorAll('.nav-links a')[3].textContent = translations.navContact[lang];
                translateBtn.textContent = translations.translateBtn[lang];
                
                // About section
                document.querySelector('#about h2').textContent = translations.aboutTitle[lang];
                document.querySelectorAll('.profile-text p')[0].textContent = translations.aboutText1[lang];
                document.querySelectorAll('.profile-text p')[1].textContent = translations.aboutText2[lang];
                document.querySelectorAll('.profile-text p')[2].textContent = translations.aboutText3[lang];
                document.querySelectorAll('.profile-text p')[3].textContent = translations.aboutText4[lang];
                
                // PCTO section
                document.querySelector('#pcto h2').textContent = translations.pctoTitle[lang];
                
                // PCTO Cards - Updated for new structure
                document.querySelectorAll('.pcto-card .pcto-title')[0].textContent = translations.pctoWhere[lang];
                document.querySelectorAll('.pcto-card .pcto-subtitle')[0].textContent = translations.pctoWhereSubtitle[lang];
                document.querySelectorAll('.pcto-card .pcto-description p')[0].textContent = translations.pctoWhereText1[lang];
                document.querySelectorAll('.pcto-card .pcto-description p')[1].textContent = translations.pctoWhereText2[lang];
                
                document.querySelectorAll('.pcto-card .pcto-title')[1].textContent = translations.pctoWhat[lang];
                document.querySelectorAll('.pcto-card .pcto-subtitle')[1].textContent = translations.pctoWhatSubtitle[lang];
                document.querySelectorAll('.pcto-card .pcto-description p')[2].textContent = translations.pctoWhatIntro[lang];
                document.querySelectorAll('.pcto-card .pcto-description li')[0].textContent = translations.pctoWhatList1[lang];
                document.querySelectorAll('.pcto-card .pcto-description li')[1].textContent = translations.pctoWhatList2[lang];
                document.querySelectorAll('.pcto-card .pcto-description li')[2].textContent = translations.pctoWhatList3[lang];
                document.querySelectorAll('.pcto-card .pcto-description li')[3].textContent = translations.pctoWhatList4[lang];
                
                document.querySelectorAll('.pcto-card .pcto-title')[2].textContent = translations.pctoLearned[lang];
                document.querySelectorAll('.pcto-card .pcto-subtitle')[2].textContent = translations.pctoLearnedSubtitle[lang];
                document.querySelectorAll('.pcto-card .pcto-description p')[3].textContent = translations.pctoLearnedIntro[lang];
                document.querySelectorAll('.pcto-card .pcto-description li')[4].textContent = translations.pctoLearnedList1[lang];
                document.querySelectorAll('.pcto-card .pcto-description li')[5].textContent = translations.pctoLearnedList2[lang];
                document.querySelectorAll('.pcto-card .pcto-description li')[6].textContent = translations.pctoLearnedList3[lang];
                document.querySelectorAll('.pcto-card .pcto-description li')[7].textContent = translations.pctoLearnedList4[lang];
                
                document.querySelectorAll('.pcto-card .pcto-title')[3].textContent = translations.pctoChallenges[lang];
                document.querySelectorAll('.pcto-card .pcto-subtitle')[3].textContent = translations.pctoChallengesSubtitle[lang];
                document.querySelectorAll('.pcto-card .pcto-description p')[4].textContent = translations.pctoChallengesIntro[lang];
                document.querySelectorAll('.pcto-card .pcto-description li')[8].textContent = translations.pctoChallengesList1[lang];
                document.querySelectorAll('.pcto-card .pcto-description li')[9].textContent = translations.pctoChallengesList2[lang];
                document.querySelectorAll('.pcto-card .pcto-description li')[10].textContent = translations.pctoChallengesList3[lang];
                document.querySelectorAll('.pcto-card .pcto-description p')[5].textContent = translations.pctoChallengesConclusion[lang];
                
                // Hobbies section - Updated for new structure
                document.querySelector('#hobbies h2').textContent = translations.hobbiesTitle[lang];
                
                document.querySelectorAll('.hobby-card .hobby-title')[0].innerHTML = `<i class="fas fa-dumbbell hobby-icon"></i>${translations.hobbiesGym[lang]}`;
                document.querySelectorAll('.hobby-card .hobby-description p')[0].textContent = translations.hobbiesGymText1[lang];
                document.querySelectorAll('.hobby-card .hobby-description p')[1].textContent = translations.hobbiesGymText2[lang];
                
                document.querySelectorAll('.hobby-card .hobby-title')[1].innerHTML = `<i class="fas fa-car hobby-icon"></i>${translations.hobbiesCars[lang]}`;
                document.querySelectorAll('.hobby-card .hobby-description p')[2].textContent = translations.hobbiesCarsText1[lang];
                document.querySelectorAll('.hobby-card .hobby-description p')[4].textContent = translations.hobbiesCarsText2[lang];
                
                document.querySelectorAll('.hobby-card .hobby-title')[2].innerHTML = `<i class="fas fa-laptop-code hobby-icon"></i>${translations.hobbiesTech[lang]}`;
                document.querySelectorAll('.hobby-card .hobby-description p')[5].textContent = translations.hobbiesTechText1[lang];
                document.querySelectorAll('.hobby-card .hobby-description p')[6].textContent = translations.hobbiesTechText2[lang];
                
                // Contact section
                document.querySelector('#contact h2').textContent = translations.contactTitle[lang];
                document.querySelector('label[for="name"]').textContent = translations.contactName[lang];
                document.querySelector('#name').placeholder = translations.contactNamePlaceholder[lang];
                document.querySelector('label[for="email"]').textContent = translations.contactEmail[lang];
                document.querySelector('#email').placeholder = translations.contactEmailPlaceholder[lang];
                document.querySelector('label[for="message"]').textContent = translations.contactMessage[lang];
                document.querySelector('#message').placeholder = translations.contactMessagePlaceholder[lang];
                document.querySelector('.submit-btn').textContent = translations.contactButton[lang];
                
                // Footer
                document.querySelectorAll('footer p')[0].textContent = translations.footerCopyright[lang];
                document.querySelectorAll('footer p')[1].textContent = translations.footerProject[lang];
            });
        });
    </script>
</body>
</html>