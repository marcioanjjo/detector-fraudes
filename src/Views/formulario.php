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
                    type="text" 
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
                <!-- Seção de Conteúdo para o AdSense -->
        <section class="max-w-4xl mx-auto px-4 mt-12 text-left space-y-6 text-gray-300">
            <hr class="border-gray-800 my-8">
            
            <h2 class="text-xl font-bold text-white mb-4">Como funciona o Detector de Links Suspeitos?</h2>
            
            <div class="bg-gray-900/50 p-6 rounded-lg border border-gray-800 space-y-4">
                <div>
                    <h3 class="text-blue-400 font-semibold mb-1">O que é esta ferramenta de segurança?</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Nossa plataforma realiza uma auditoria em tempo real em links patrocinados e URLs que circulam em redes sociais. O objetivo é analisar a estrutura do link, a presença de múltiplos rastreadores ocultos e redirecionamentos suspeitos que comumente são utilizados em páginas de fraudes eletrônicas, golpes de Pix e falsas promoções.
                    </p>
                </div>

                <div>
                    <h3 class="text-blue-400 font-semibold mb-1">Como identificar um link perigoso ou falso?</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Links legítimos de grandes portais costumam ser diretos e limpos. Já páginas clonadas ou criadas por engenharia social para roubo de dados utilizam encurtadores de URL maliciosos ou parâmetros de afiliados excessivos para monitorar as vítimas e comissões. Nosso motor varre essas informações para alertar você antes de clicar.
                    </p>
                </div>

                <div>
                    <h3 class="text-blue-400 font-semibold mb-1">Dicas para navegar com total segurança na internet</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Sempre desconfie de ofertas com valores excessivamente abaixo do mercado vindas de redes sociais de vídeos ou mensagens. Certifique-se de que o domínio principal na barra de endereços corresponde ao site oficial da empresa antes de inserir dados de cartões de crédito ou realizar transferências.
                    </p>
                </div>
            </div>
        </section>
    </div>

    
    <!-- Rodapé Profissional e Créditos -->
    <footer class="bg-gray-900 border-t border-gray-800 py-6 mt-12 w-full text-center text-xs text-gray-500">
        <div class="max-w-4xl mx-auto px-4 space-y-2">
            <p class="font-medium text-gray-400">
                &copy; 2026 SQL Tecnologia. Todos os direitos reservados.
            </p>
            <p>
                Plataforma desenvolvida para auditoria de segurança e conformidade de links patrocinados.
            </p>
            <p class="text-gray-600">
                Desenvolvido por: <span class="text-blue-400 font-mono">Márcio Silva</span>
            </p>
        </div>
    </footer>

</body>
</html>