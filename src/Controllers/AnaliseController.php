<?php
// src/Controllers/AnaliseController.php

class AnaliseController {
    
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
}