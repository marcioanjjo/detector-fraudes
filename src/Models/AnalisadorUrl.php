<?php
// src/Models/AnalisadorUrl.php

class AnalisadorUrl {

    public function verificar(string $url): array {
        // 1. Limpa e valida o formato da URL
        $url = filter_var(trim($url), FILTER_SANITIZE_URL);
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return [
                'status' => 'perigo',
                'mensagem' => 'O link enviado é inválido ou está mal formatado.'
            ];
        }

        // Extrai o domínio principal (ex: mesa-de-casa.com)
        $dominio = parse_url($url, PHP_URL_HOST);

        // Inicializa as variáveis de risco
        $pontosRisco = 0;
        $motivos = [];

        // --- TESTE 1: Verificar se o site está online e responde (cURL) ---
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Segue redirecionamentos
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);           // Não trava o servidor se o site sumiu
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Evita travar por certificado local
        
        $resposta = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 0 || $httpCode >= 400) {
            $pontosRisco += 4;
            $motivos[] = 'O site está fora do ar ou inacessível. Páginas de golpes costumam ser desativadas rapidamente após denúncias.';
        }

        // --- TESTE 2: Origem de Redes Sociais (Parâmetros de Anúncios) ---
        $urlLower = strtolower($url);
        if (str_contains($urlLower, 'utm_source=kwai') || 
            str_contains($urlLower, 'utm_source=instagram') || 
            str_contains($urlLower, 'utm_source=tiktok') ||
            str_contains($urlLower, 'click_id')) {
            
            $pontosRisco += 2;
            $motivos[] = 'Este link contém rastreadores de anúncios de redes sociais (Kwai/Instagram/TikTok). Golpistas patrocinam muitas publicações falsas nessas plataformas.';
        }

        // --- TESTE 3: Termos Suspeitos na URL ---
        $termosPerigosos = ['promocao', 'sorteio', 'ganhe', 'brinde', 'indique', 'resgatar', 'recarga', 'vaga-de-emprego'];
        foreach ($termosPerigosos as $termo) {
            if (str_contains($urlLower, $termo)) {
                $pontosRisco += 2;
                $motivos[] = "A URL contém a palavra de alto contágio publicitário: '<strong>{$termo}</strong>'.";
                break; // Achou um termo, já soma os pontos
            }
        }

        // --- Classificação Final com Base nos Pontos ---
        if ($pontosRisco >= 4) {
            $status = 'perigo';
            $mensagem = '⚠️ ALERTA DE ALTO RISCO: Este link apresenta múltiplos padrões de fraudes ou já foi desativado.';
        } elseif ($pontosRisco >= 2) {
            $status = 'alerta';
            $mensagem = '🔍 ATENÇÃO: Link suspeito. Ele veio de anúncios ou usa iscas promocionais. Verifique a fonte oficial.';
        } else {
            $status = 'seguro';
            $mensagem = '✅ NENHUM PADRÃO DETECTADO: O link respondeu normalmente, mas lembre-se de nunca fazer Pix sem confirmar a identidade da empresa.';
        }

        return [
            'dominio' => $dominio,
            'status' => $status,
            'mensagem' => $mensagem,
            'motivos' => $motivos
        ];
    }
}