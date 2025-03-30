FILMESPVH - Sistema de Catálogo de Filmes (API RESTful em PHP MVC)
PHP
MySQL
License

📌 Visão Geral
API RESTful para gerenciamento de catálogo de filmes desenvolvida em PHP seguindo padrão MVC com sistema de rotas avançado.

✨ Recursos Principais
✅ CRUD completo de filmes

✅ Filtragem por categorias

✅ Sistema de rotas dinâmicas

✅ Padrão MVC com herança de classes

✅ CORS configurado

✅ Respostas em JSON

🛠 Stack Tecnológica
Tecnologia	Função
PHP 7.4+	Lógica backend
MySQL	Banco de dados
PDO	Conexão com banco
Composer	Gerenciamento de dependências
MVC	Arquitetura do projeto
🚀 Instalação
Pré-requisitos
PHP 7.4+

MySQL 5.7+

Composer

Apache/Nginx

Passo a Passo
Clone o repositório:

bash

git clone https://github.com/jjosuessousa/backend_filme.git
cd backend_filme
Instale as dependências:

bash

composer install
Configure o banco de dados:

Crie um arquivo .env baseado em .env.example

Importe a estrutura do banco (schema.sql)

Inicie o servidor:

bash

php -S localhost:8000 -t public
🏗 Estrutura do Projeto


backend_filme/
     core/
        Model.php          # Classe modelo base
   Database.php       # Conexão com DB
    Router.php         # Gerenciamento de rotas
   Controller.php     # Controller base
 controllers/
 HomeController.php # Lógica das rotas
 models/
 Filme.php         # Modelo de filmes
public/
 index.php         # Ponto de entrada
 .htaccess         # Configurações Apache
 routes/
 web.php           # Definição de rotas
config/               # Configurações


🌐 Rotas da API
Método	Rota	Descrição	Parâmetros
GET	/	Página inicial	-
GET	/filme/{id}	Buscar filme	ID do filme
GET	/filmes/categoria/{categoria}	Filmes por categoria	Nome categoria
POST	/cadastrar-Filme	Criar novo filme	JSON com dados
PUT	/atualizar-filme/{id}	Atualizar filme	ID + JSON
DELETE	/deletar-filme/{id}	Remover filme	ID do filme

🧩 Exemplo de Uso
Model Filme

class Filme extends Model {
    protected static $table = 'filmes';
    
    public static function porCategoria($categoria) {
        return self::query(
            "SELECT * FROM filmes WHERE categoria = ?", 
            [$categoria]
        );
    }
}
Controller

class HomeController extends Controller {
    public function buscarFilme($id) {
        $filme = Filme::find($id);
        $this->jsonResponse($filme);
    }
}
Rotas

$router->get('/filme/{id}', 'HomeController@buscarFilme');
$router->get('/filmes/categoria/{categoria}', 'HomeController@listarPorCategoria');
🔧 Configurações Especiais
CORS (index.php)

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
.htaccess
apache

RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php [QSA,L]
🤝 Como Contribuir
Faça um fork do projeto

Crie sua branch (git checkout -b feature/nova-funcionalidade)

Commit suas mudanças (git commit -m 'Adiciona nova funcionalidade')

Push para a branch (git push origin feature/nova-funcionalidade)

Abra um Pull Request

📄 Licença
MIT License - Veja o arquivo LICENSE para detalhes.

Desenvolvido por Josué Sousa
<<<<<<< HEAD
Repositório: github.com/jjosuessousa/backend_filme
=======
Repositório: github.com/jjosuessousa/backend_filme
>>>>>>> f02cd87af50533880f78248653efc5d75757f63b
