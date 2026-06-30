<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detector de Links Suspeitos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col justify-center items-center p-4">

    <div class="max-w-2xl w-full bg-gray-800 p-8 rounded-2xl shadow-2xl border border-gray-700">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-red-500 mb-2">🛡️ Verificador de Fraudes</h1>
            <p class="text-gray-400 text-sm">Cole o link de promoções de WhatsApp, Kwai, Instagram ou SMS para analisar o risco.</p>
        </div>

        <form action="index.php?action=analisar" method="POST" class="space-y-4">
            <div>
                <label for="url_suspeita" class="block text-sm font-medium text-gray-300 mb-2">URL / Link Suspeito:</label>
                <input 
                    type="url" 
                    id="url_suspeita" 
                    name="url_suspeita" 
                    required 
                    placeholder="https://exemplo-com-promocao-falsa.com/ganhe-premios..." 
                    class="w-full p-4 rounded-xl bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                >
            </div>

            <button 
                type="submit" 
                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold p-4 rounded-xl shadow-lg hover:shadow-red-900/50 transition duration-200"
            >
                Analisar Link Agora
            </button>
        </form>
    </div>

    <footer class="mt-8 text-xs text-gray-500 text-center space-y-2">
        <p>Projeto Antifraude Open-Source • Desenvolvido com PHP Puro e Docker</p>
        <div class="space-x-4">
            <a href="index.php?action=privacidade" class="underline hover:text-gray-400">Política de Privacidade</a>
            <a href="index.php?action=termos" class="underline hover:text-gray-400">Termos de Uso</a>
        </div>
    </footer>

</body>
</html>