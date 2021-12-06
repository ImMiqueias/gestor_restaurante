<?php
define("view", "app/Views");
define("controller", "app/Controllers");
if(isset($_GET['page'])) 
{
    switch($_GET['page']) 
    {
        case 'home':
            require view . '/home.php';break;
        case 'form-receita':
            require view . '/form_receita.php';break;
        case 'form-ingrediente':
            require view . '/form_ingrediente.php';break;
        case 'gerir-receitas':
            require view . '/gerir_receitas.php';break;

        case 'add-ingrediente':
            require controller . '/salvar_ingrediente.php';break;
        case 'add-receita':
            require controller . '/salvar_receita.php';break;
        case 'remover-ingrediente':
            require controller . '/apaga_ingrediente.php';break;
        case 'remover-receita':
            require controller . '/apaga_receita.php';break;
        case 'registrar-venda':
            require controller . '/registrar_venda.php';break;
        case 'info-receita':
            require controller . '/info_receita.php';break;
        default:
            echo "<h1>Page not found.</h1>";break;
    }
}
else 
{
    require view . '/home.php';
}