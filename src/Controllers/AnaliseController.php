<?php

// src/Controllers/AnaliseController.php

/* class AnaliseController {
    
    // Método que exibe o formulário principal (Página Inicial)
    public function index() {
        // O __DIR__ garante que o PHP ache a pasta Views a partir daqui
        include __DIR__ . '/../Views/formulario.php';
    }

    // Método que processará a análise do link
    public function analisar() {
        // Captura o link enviado pelo formulário POST
        $urlSuspeita = $_POST['url_suspeita'] ?? '';

        // Se o usuário não digitou nada, joga ele de volta para o início
        if (empty($urlSuspeita)) {
            header('Location: index.php');
            exit;
        }

        // Por enquanto, criamos uma resposta de teste para a tela não quebrar
        $resultado = [
            'url' => $urlSuspeita,
            'status' => 'alerta',
            'detalhes' => 'O controlador recebeu seu link, o modelo de análise será ativado em breve.'
        ];

        // Carrega a tela que vai mostrar o resultado (vamos criar ela a seguir)
        include __DIR__ . '/../Views/resultado.php';
    }

    // Método para a página de Privacidade (Exigência Google Ads)
    public function privacidade() {
        include __DIR__ . '/../Views/privacidade.php';
    }

    // Método para a página de Termos de Uso (Exigência Google Ads)
    public function termos() {
        include __DIR__ . '/../Views/termos.php';
    }
} */


// src/Controllers/AnaliseController.php



class AnaliseController {
    
    // Método que exibe o formulário principal (Página Inicial)
    public function index() {
        // Usar realpath e dirname evita erros de caminhos relativos em servidores Linux/Docker
        include dirname(__DIR__) . '/Views/formulario.php';
    }

    // Método que processará a análise do link
    // Método que processará a análise do link dentro de src/Controllers/AnaliseController.php
    public function analisar() {
        $urlSuspeita = $_POST['url_suspeita'] ?? '';

        if (empty($urlSuspeita)) {
            header('Location: index.php');
            exit;
        }

        // Importa o arquivo do Model manualmente (já que não temos Composer)
        require_once dirname(__DIR__) . '/Models/AnalisadorUrl.php';

        // Instancia o modelo e executa as checagens
        $analisador = new AnalisadorUrl();
        $resultado = $analisador->verificar($urlSuspeita);

        // Carrega a tela passando o array $resultado real
        include dirname(__DIR__) . '/Views/resultado.php';
    }

    // Página de Privacidade
    public function privacidade() {
        include dirname(__DIR__) . '/Views/privacidade.php';
    }

    // Página de Termos de Uso
    public function termos() {
        include dirname(__DIR__) . '/Views/termos.php';
    }
}