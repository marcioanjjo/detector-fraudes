<div align="center">

# Detector de Fraudes

Uma aplicação web em PHP para realizar uma triagem heurística de links suspeitos antes que o usuário interaja com eles.

![PHP 8.2](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white)
![Apache](https://img.shields.io/badge/Apache-2.4-D22128?logo=apache&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?logo=docker&logoColor=white)

</div>

## Sobre o projeto

O Detector de Fraudes analisa uma URL enviada pelo usuário e apresenta um resultado classificado como **seguro**, **alerta** ou **perigo**. A aplicação combina validação estrutural, consulta ao endereço informado e identificação de sinais comuns em links de campanhas suspeitas, golpes de Pix e páginas de falsa promoção.

O projeto foi desenvolvido com PHP puro, seguindo uma organização simples inspirada no padrão MVC, e pode ser executado localmente com Docker Compose.

> **Importante:** o resultado é uma análise automatizada baseada em heurísticas. Um link classificado como seguro não representa garantia de legitimidade, e um alerta não substitui a verificação manual do domínio e da empresa responsável.

## Funcionalidades

- Aceita URLs com ou sem `http://` ou `https://`.
- Valida o formato da URL antes de iniciar a análise.
- Verifica se o endereço responde e acompanha redirecionamentos.
- Compara o domínio informado com o domínio final após os redirecionamentos.
- Procura menções a Pix e ao sistema “copia e cola” no HTML retornado.
- Identifica parâmetros de rastreamento associados a anúncios e afiliados.
- Detecta termos promocionais frequentemente usados em páginas de engenharia social.
- Exibe os motivos que contribuíram para a classificação.
- Disponibiliza páginas de Política de Privacidade e Termos de Uso.

## Como funciona a classificação

Cada sinal encontrado adiciona pontos ao risco da URL. A classificação final usa os seguintes limites:

| Pontuação | Status | Interpretação |
| ---: | --- | --- |
| `0` | Seguro | Nenhum padrão de risco foi identificado pela análise. |
| `1` a `2` | Alerta | Existe pelo menos um sinal que merece atenção. |
| `3` ou mais | Perigo | Foram encontrados múltiplos sinais ou um problema relevante de acesso. |

Principais pesos aplicados pelo analisador:

- **+4:** site inacessível ou resposta HTTP de erro (`400+`).
- **+3:** redirecionamento para um domínio principal diferente.
- **+2:** menções a “chave Pix” ou “copia e cola” no conteúdo retornado.
- **+1 por ocorrência:** parâmetros de anúncios, campanhas, afiliados e rastreadores.
- **+2:** termos promocionais suspeitos na URL.

## 📌 Demonstração Online

* **Site em Produção:** [detector.sqltecnologia.inf.br](https://detector.sqltecnologia.inf.br/)

## Tecnologias

- PHP 8.2+
- Apache 2.4
- Docker e Docker Compose
- cURL para consultas HTTP
- Tailwind CSS via CDN na camada de apresentação

Não há banco de dados, Composer ou dependências de terceiros instaladas localmente neste momento.

## Pré-requisitos

Para executar com Docker:

- Docker Desktop ou Docker Engine instalado e em execução.
- Docker Compose disponível, integrado ao Docker Desktop ou como `docker compose`.
- Porta `8080` livre na máquina host.

## Executando com Docker

Na raiz do repositório, execute:

```bash
docker compose -f docker/docker-compose.yml up --build
```

Depois, abra [http://localhost:8080](http://localhost:8080) no navegador.

Para executar em segundo plano:

```bash
docker compose -f docker/docker-compose.yml up -d --build
```

Para parar os containers:

```bash
docker compose -f docker/docker-compose.yml down
```

O diretório `src/` é montado diretamente em `/var/www/html`, portanto alterações no código ficam disponíveis no container sem uma etapa adicional de build.

## Executando sem Docker

Também é possível usar o servidor embutido do PHP, desde que o PHP esteja instalado com a extensão cURL habilitada:

```bash
php -S localhost:8080 -t src
```

Acesse [http://localhost:8080](http://localhost:8080).

## Rotas disponíveis

| Rota | Método | Descrição |
| --- | --- | --- |
| `index.php` | `GET` | Exibe o formulário inicial. |
| `index.php?action=analisar` | `POST` | Analisa o campo `url_suspeita`. |
| `index.php?action=privacidade` | `GET` | Exibe a Política de Privacidade. |
| `index.php?action=termos` | `GET` | Exibe os Termos de Uso. |

Exemplo de requisição:

```bash
curl -X POST -d "url_suspeita=https://exemplo.com" http://localhost:8080/index.php?action=analisar
```

## Estrutura do projeto

```text
.
├── docker/
│   └── docker-compose.yml       # Serviço Apache/PHP
├── src/
│   ├── index.php                # Ponto de entrada e roteamento
│   ├── Controllers/
│   │   └── AnaliseController.php
│   ├── Models/
│   │   └── AnalisadorUrl.php     # Regras de análise e pontuação
│   └── Views/
│       ├── formulario.php
│       ├── resultado.php
│       ├── privacidade.php
│       └── termos.php
└── README.MD
```

## Segurança e limitações conhecidas

- A aplicação realiza requisições para endereços fornecidos pelo usuário. Em um ambiente público, é importante adicionar controles contra SSRF, limitar destinos privados e aplicar rate limiting.
- A análise do HTML é textual e heurística; ela não executa JavaScript nem substitui uma solução de reputação, sandbox ou antivírus.
- O tempo limite da consulta é de cinco segundos, e redirecionamentos são seguidos automaticamente.
- A verificação de certificado TLS está desativada no analisador atual. Isso deve ser reavaliado antes de usar a aplicação em produção.
- URLs submetidas podem conter tokens e dados sensíveis. Evite analisar links privados ou com informações pessoais.

## Próximos passos sugeridos

- Adicionar testes automatizados para validação de URLs, pontuação e classificação.
- Reativar e validar a verificação de certificados TLS.
- Implementar proteção contra SSRF, limites de tamanho e rate limiting.
- Separar a lógica de análise HTTP da classificação para facilitar manutenção e testes.
- Adicionar logs estruturados e observabilidade sem registrar dados sensíveis.

## Licença

Este projeto está sob a licença MIT. Consulte o arquivo [LICENSE](LICENSE) para obter mais detalhes.

---

Desenvolvido por **Marcio dos Anjos Silva**  
**Empresa:** [SQL Tecnologia](https://sqltecnologia.inf.br)  
**LinkedIn:** [linkedin.com/in/marciosilva](https://www.linkedin.com/in/marciosilvawww.linkedin.com/in/marciosilvasqltecnologia)  
**GitHub:** [github.com/marcioanjjo](https://github.com/marcioanjjo)