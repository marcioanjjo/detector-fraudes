<?php
// src/Models/AnalisadorUrl.php

class AnalisadorUrl {

    public function verificar(string $url): array {
        /* // 1. Limpa e valida o formato da URL
        $url = filter_var(trim($url), FILTER_SANITIZE_URL);
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return [
                'status' => 'perigo',
                'mensagem' => 'O link enviado é inválido ou está mal formatado.',
                'motivos' => ['A URL enviada não possui um formato estrutural válido.']
            ];
        } */
        // Extrai o domínio principal (ex: mesa-de-casa.com)
        //$dominio = parse_url($url, PHP_URL_HOST);

            // 1. Remove espaços em branco acidentais nas pontas
        $url = trim($url);

        // 2. Se o utilizador digitou sem http ou https (ex: www.google.com ou google.com.br)
        if (!str_starts_with(strtolower($url), 'http://') && !str_starts_with(strtolower($url), 'https://')) {
            $url = 'https://' . $url; // Adiciona o protocolo automaticamente nos bastidores
        }

        // 3. Limpa e valida o formato estrutural da URL com a regra rígida do PHP
        $url = filter_var($url, FILTER_SANITIZE_URL);
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return [
                'status' => 'perigo',
                'mensagem' => 'O link enviado é inválido ou está mal formatado.',
                'motivos' => ['A URL enviada não possui um formato estrutural válido. Certifique-se de digitar um domínio real.']
            ];
        }

        // 4. Extrai o domínio principal para continuar a análise do cURL (o resto do seu código continua igual...)
        $dominio = parse_url($url, PHP_URL_HOST);

        // Inicializa as variáveis de risco
        $pontosRisco = 0;
        $motivos = [];

        // --- TESTE 1: Verificar se o site está online e responde (cURL) ---
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Segue redirecionamentos
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);           // Não trava o servidor
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Evita travar por certificado local
        
        $resposta = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $urlFinal = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL); // Captura a URL final
        

        // PESO 4: Se o site der erro pesado de conexão ou sumiu
        if ($httpCode === 0 || $httpCode >= 400) {
            $pontosRisco += 4;
            $motivos[] = 'O site está fora do ar ou inacessível. Páginas de golpes costumam ser desativadas rapidamente após denúncias.';
        }

        // PESO 3: Redirecionamento suspeito (Tentou mascarar o domínio real)
        $dominioFinal = parse_url($urlFinal, PHP_URL_HOST);
        if ($dominioFinal !== $dominio && !str_contains($dominioFinal, $dominio)) {
            $pontosRisco += 3;
            $motivos[] = "O link original tentou mascarar o destino e redirecionou o utilizador para um site diferente: <strong>{$dominioFinal}</strong>.";
        }

        // PESO 2: Leitura do HTML buscando menções a Pix
        if (!empty($resposta) && (str_contains(strtolower($resposta), 'chave pix') || str_contains(strtolower($resposta), 'copia e cola'))) {
            $pontosRisco += 2;
            $motivos[] = "O conteúdo da página faz menção direta a transações Pix imediatas ou sistemas 'Copia e Cola'.";
        }

        // --- TESTE 2: Origem de Redes Sociais (Parâmetros de Anúncios e Afiliados) ---
        $urlLower = strtolower($url);
        $parametrosSuspeitos = ['utm_source=kwai', 'utm_source=instagram', 'utm_source=tiktok', 'utm_source=facebook', 'click_id=', 'utm_campaign=', 'aff_id='];
        $rastreadoresEncontrados = 0;

        foreach ($parametrosSuspeitos as $param) {
            if (str_contains($urlLower, $param)) {
                $rastreadoresEncontrados++;
            }
        }

        // Se encontrou rastreadores, soma os pontos (1 rastreador = +1 ponto, 3 rastreadores = +3 pontos!)
        if ($rastreadoresEncontrados > 0) {
            $pontosRisco += $rastreadoresEncontrados;
            
            if ($rastreadoresEncontrados >= 3) {
                $motivos[] = "Este link contém <strong>{$rastreadoresEncontrados} rastreadores</strong> ocultos. Redes de golpes usam múltiplos códigos (como click_id e campaigns) para dividir comissões de fraudes.";
            } else {
                $motivos[] = 'Este link contém rastreadores de anúncios de redes sociais. Fique atento à fonte oficial.';
            }
        }

        // --- TESTE 3: Termos Suspeitos na URL ---
        // PESO 2: Palavras de alta atração publicitária que golpes usam
        $termosPerigosos = ['promocao', 'sorteio', 'ganhe', 'brinde', 'indique', 'resgatar', 'recarga', 'vaga-de-emprego'];
        foreach ($termosPerigosos as $termo) {
            if (str_contains($urlLower, $termo)) {
                $pontosRisco += 2;
                $motivos[] = "A URL contém uma palavra de forte apelo promocional: '<strong>{$termo}</strong>'.";
                break;
            }
        }

        // --- Classificação Final Equilibrada (Limite = 3) ---
        if ($pontosRisco >= 3) {
            $status = 'perigo'; // VERMELHO
            $mensagem = '⚠️ ALERTA DE ALTO RISCO: Este link apresenta múltiplos critérios de fraude ou desvios de segurança graves.';
        } elseif ($pontosRisco >= 1) {
            $status = 'alerta'; // AMARELO
            $mensagem = '🔍 ATENÇÃO: Link em observação. Ele originou-se de um anúncio patrocinado ou usa palavras promocionais.';
        } else {
            $status = 'seguro'; // VERDE
            $mensagem = '✅ NENHUM PADRÃO DETECTADO: O link respondeu normalmente. Mantenha a cautela antes de realizar pagamentos.';
        }

        return [
            'dominio' => $dominio,
            'status' => $status,
            'mensagem' => $mensagem,
            'motivos' => $motivos
        ];
    }
}