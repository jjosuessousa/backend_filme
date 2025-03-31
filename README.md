FILMESPVH - Sistema de Catálogo de Filmes (API RESTful em PHP MVC)
PHP
MySQL


📌 Visão Geral:

API RESTful para gerenciamento de catálogo de filmes desenvolvida em PHP seguindo padrão MVC com sistema de rotas avançado.

✨ Recursos Principais:

✅ CRUD completo de filmes

✅ Filtragem por categorias

✅ Sistema de rotas dinâmicas

✅ Padrão MVC com herança de classes

✅ CORS configurado

✅ Respostas em JSON

🛠 Stack Tecnológica:

TecnologiA USADA

    PHP 7.4+    	Lógica backend
     MySQL    	Banco de dados
      PDO	Conexão com banco
    Composer	Gerenciamento de dependências
    MVC 	Arquitetura do projeto

🚀 Instalação

Pré-requisitos
PHP 7.4+

MySQL 5.7+

Composer

Apache/Nginx

Passo a Passo:

Clone o repositório:

bash

git clone https://github.com/jjosuessousa/backend_filme.git

cd backend_filme
Instale as dependências:


Inicie o servidor:

bash

php -S localhost:8000 -t public

Vá até a pasta do projeto, pelo prompt/terminal e execute:

composer install

DENTRO  DA PASTA DO SEU PROJETO ABRA TERMINAL
 é necessário rodar o composer pra instalar as dependências e gerar o autoload.

      

🌐 Rotas da API:

Método	Rota	Descrição	Parâmetros:

GET	/	Página inicial	-

GET	/filme/{id}	Buscar filme	ID do filme

GET	/filmes/categoria/{categoria}	#Filmes por 
categoria	Nome categoria

POST	/cadastrar-Filme	#Criar novo filme	JSON com dados

PUT	/atualizar-filme/{id}	#Atualizar filme	ID + JSON

DELETE	/deletar-filme/{id}#	Remover filme	ID do filme

🧩 Exemplo de Uso:
Model Filme: herdando a classe model de core

class Filme extends Model {

    protected static $table = 'filmes';
    
    public static function porCategoria($categoria) {
        return self::query(
            "SELECT * FROM filmes WHERE categoria = ?", 
            [$categoria]
        );
    }
}

USANDO AS CONTROLADORAS:

Controller.php

class HomeController extends Controller {

            public function buscarFilme($id) {
      $filme = Filme::find($id);
                  $this->jsonResponse($filme);
            }
        }
Rotas:

$router->get('/filme/{id}', 'HomeController@buscarFilme');

$router->get('/filmes/categoria/{categoria}',

'HomeController@listarPorCategoria');

$router->post('/cadastrar-Filme', 

$router->get('/listar-filme', 

'HomeController@listarFilmes');

$router->delete('/deletar-filme/{id}', 

'HomeController@deletarFilme');

$router->put('/atualizar-filme/{id}',

'HomeController@atualizarFilme');

$router->get('/filme/{id}', 

'HomeController@buscarFilme');

$router->get('/filme/ListarCategorias', 

'HomeController@ListarCategorias');

$router->get('/filmes/categoria/{categoria}


🔧 Configurações Especiais

CORS (index.php)

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");


.htaccess:
apache

RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php [QSA,L]


📌 Resumo
✔ Model.php (Core) → Classe pai com métodos de banco de dados.

✔ Filme.php → Herda de Model e implementa consultas específicas.

✔ Rotas → Definidas em web.php e direcionadas para o Controller.

✔ Controller → Recebe requisições e chama o Model.

✔ Index.php → Ponto de entrada que inicia o roteador.

✔ json → composer.json é o coração da configuração do seu projeto PHP.

✔ htaccess →O arquivo .htaccess é um arquivo de configuração do servidor Apache que permite controlar o comportamento do seu site a nível de diretório


🤝 Como Contribuir:

Faça um fork do projeto

Crie sua branch (git checkout -b feature/nova-funcionalidade)

Commit suas mudanças (git commit -m 'Adiciona nova funcionalidade')

Push para a branch (git push origin feature/nova-funcionalidade)

Abra um Pull Request

📄 Licença
MIT License - Veja o arquivo LICENSE para detalhes.

Desenvolvido por Josué Sousa

Repositório: github.com/jjosuessousa/backend_filme
