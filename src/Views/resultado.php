<?php
// src/Views/resultado.php

// Se por algum motivo a variável não existir, redireciona o usuário para a página inicial
if (!isset($resultado) || empty($resultado)) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Análise - Verificador de Fraudes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col justify-center items-center p-4">

    <div class="max-w-2xl w-full bg-gray-800 p-8 rounded-2xl shadow-2xl border border-gray-700">
        
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold mb-2">Análise do Domínio: <span class="text-blue-400 font-mono"><?php echo htmlspecialchars($resultado['dominio'] ?? 'Link'); ?></span></h1>
            
            <div class="p-4 rounded-xl font-bold mt-4 text-lg
                <?php 
                    echo $resultado['status'] === 'perigo' ? 'bg-red-900/50 text-red-400 border border-red-700' : 
                        ($resultado['status'] === 'alerta' ? 'bg-yellow-900/50 text-yellow-400 border border-yellow-700' : 
                        'bg-green-900/50 text-green-400 border border-green-700'); 
                ?>">
                <?php echo $resultado['mensagem']; ?>
            </div>
        </div>

        <?php if (!empty($resultado['motivos'])): ?>
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-3">Pontos de atenção detectados:</h3>
                <ul class="space-y-3">
                    <?php foreach ($resultado['motivos'] as $motivo): ?>
                        <li class="bg-gray-700/50 p-3 rounded-lg border-l-4 border-red-500 text-sm leading-relaxed">
                            <?php echo $motivo; ?>
                        </li>
                    <?php endforeach; ?> </ul>
            </div>
        <?php endif; ?>

        <a href="index.php" class="inline-block w-full text-center bg-gray-700 hover:bg-gray-600 text-white font-bold p-4 rounded-xl transition duration-200 shadow-md">
            Analisar outro link
        </a>
    </div>

</body>
</html>