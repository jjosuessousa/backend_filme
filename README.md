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
Copy
git clone https://github.com/jjosuessousa/backend_filme.git
cd backend_filme
Instale as dependências:

bash
Copy
composer install
Configure o banco de dados:

Crie um arquivo .env baseado em .env.example

Importe a estrutura do banco (schema.sql)

Inicie o servidor:

bash
Copy
php -S localhost:8000 -t public
🏗 Estrutura do Projeto
Copy
backend_filme/
├── core/
│   ├── Model.php          # Classe modelo base
│   ├── Database.php       # Conexão com DB
│   ├── Router.php         # Gerenciamento de rotas
│   └── Controller.php     # Controller base
├── controllers/
│   └── HomeController.php # Lógica das rotas
├── models/
│   └── Filme.php         # Modelo de filmes
├── public/
│   ├── index.php         # Ponto de entrada
│   └── .htaccess         # Configurações Apache
├── routes/
│   └── web.php           # Definição de rotas
└── config/               # Configurações
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
php
Copy
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
php
Copy
class HomeController extends Controller {
    public function buscarFilme($id) {
        $filme = Filme::find($id);
        $this->jsonResponse($filme);
    }
}
Rotas
php
Copy
$router->get('/filme/{id}', 'HomeController@buscarFilme');
$router->get('/filmes/categoria/{categoria}', 'HomeController@listarPorCategoria');
🔧 Configurações Especiais
CORS (index.php)
php
Copy
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
.htaccess
apache
Copy
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
Repositório: github.com/jjosuessousa/backend_filme