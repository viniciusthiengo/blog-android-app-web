
$('ul.menu li a:not(.sair)').click(function( e ){
    e.preventDefault();
    var $handler = $(this);
    var dados, callback, metodo;
    var ctrl = $handler.prop('href');

    ctrl = ctrl.split('#');
    ctrl = ctrl[ ctrl.length - 1 ];
    ctrl = ctrl.split('|');
    metodo = ctrl[1];
    ctrl = ctrl[0];
    checkedLink( $handler );

    dados = { 'metodo': metodo };
    callback = function(data){
        $('div.content').html( data.html );
    };

    ajaxRequest( ctrl, dados, callback );
});

$('ul.menu li a.sair').click(function( e ){
    e.preventDefault();
    var $handler = $(this);
    var dados, callback, metodo;
    var ctrl = $handler.prop('href');

    ctrl = ctrl.split('#');
    ctrl = ctrl[ ctrl.length - 1 ];
    ctrl = ctrl.split('|');
    metodo = ctrl[1];
    ctrl = ctrl[0];
    checkedLink( $handler );

    dados = { 'metodo': metodo };
    callback = function(data){
        window.location = './'; /* RECARREGANDO A PÁGINA */
    };

    ajaxRequest( ctrl, dados, callback );
});


/* ADMIN */
$(document).on('submit', '#form-login', function( e ){
    e.preventDefault();
    var $handler = $(this);
    var dados = {
        'metodo': $('#metodo').val(),
        'email': $('#cp-email').val(),
        'password': $('#cp-password').val()
    };
    var callback = function(data){
        if( data.resultado == 1 ){
            window.location = './'; /* RECARREGANDO A PÁGINA */
        }
        else{
            buttonLabel( $handler, 'Entrar' );
            snackBar( 'Falhou! Tente novamente.' );
        }
    };

    buttonLabel( $handler, 'Verificando...' );
    ajaxRequest( 'CtrlAdmin', dados, callback );
});


$(document).on('submit', '#form-atualizar-email-login, #form-atualizar-password-login', function( e ){
    e.preventDefault();
    var $handler = $(this);
    var ehAtualizacaoEmail = $('#cp-email').length == 1;
    var mensagemFeedback = ehAtualizacaoEmail ? 'Email atualizado com sucesso!' : 'Senha atualizada com sucesso!';
    var buttonEndLabel = ehAtualizacaoEmail ? 'Atualizar email' : 'Atualizar senha';

    var dados = {
        'metodo': $('#metodo').val(),
        'password': $('#cp-password').val(),
        'novo-password': $('#cp-novo-password').val(),
        'email': $('#cp-email').val()
    };
    var callback = function(data){
        buttonLabel( $handler, buttonEndLabel );
        if( data.resultado == 1 ){
            snackBar( mensagemFeedback );
            limparCampos( $handler );
        }
        else{
            snackBar( 'Falhou! Reveja os campos e tente novamente.' );
        }
    };

    buttonLabel( $handler, 'Atualizando...' );
    ajaxRequest( 'CtrlAdmin', dados, callback );
});


/* POST */
$(document).on('submit', '#form-criar-post, #form-atualizar-post', function( e ){
    e.preventDefault();
    var $handler = $(this);
    var ehAtualizacao = $('#cp-post').length == 1;
    var mensagemFeedback = ehAtualizacao ? 'Post atualizado com sucesso!' : 'Post criado com sucesso!';
    var buttonSendingLabel = ehAtualizacao ? 'Atualizando post...' : 'Criando post...';
    var buttonEndLabel = ehAtualizacao ? 'Atualizar post' : 'Criar post';

    var dados = {
        'metodo': $('#metodo').val(),
        'id': $('#cp-post').val(),
        'titulo': $('#cp-titulo').val(),
        'categoria': $('#cp-categoria').val(),
        'sumario': $('#cp-sumario').val(),
        'uri-imagem': $('#cp-imagem').val()
    };
    var callback = function(data){
        buttonLabel( $handler, buttonEndLabel );
        if( data.resultado == 1 ){
            snackBar( mensagemFeedback );
            if( !ehAtualizacao ){
                limparCampos( $handler );
            }
        }
        else{
            snackBar( 'Falhou! Reveja os campos e tente novamente.' );
        }
    };

    buttonLabel( $handler, buttonSendingLabel );
    ajaxRequest( 'CtrlPost', dados, callback );
});


$(document).on('change', '#cp-post', function(){
    var $handler = $(this);
    var dados = {
        'metodo': 'get-dados-post',
        'id': $handler.val()
    };
    var callback = function(data){
        $('#cp-titulo').val( data.post.titulo );
        $('#cp-categoria').val( data.post.categoria.id );
        $('#cp-sumario').val( data.post.sumario );
        $('#cp-imagem').val( data.post.uriImagem );
    };

    ajaxRequest( 'CtrlPost', dados, callback );
});


$(document).on('click', 'button.delete', function(){
    var $handler = $(this);
    var dados = {
        'metodo': 'deletar-post',
        'id': $('#cp-post').val()
    };
    var callback = function(data){
        buttonLabel( $handler, 'Deletar post' );
        if( data.resultado == 1 ){
            snackBar( 'Post deletado com sucesso!' );
            $('ul.menu li a[title="Atualizar post"].checked').trigger('click');
        }
        else{
            snackBar( 'Falhou! Selecione um post e tente novamente.' );
        }
    };

    buttonLabel( $handler, 'Deletando post...' );
    ajaxRequest( 'CtrlPost', dados, callback );
});




function ajaxRequest( ctrl, dados, callback ){
    $.ajax({
        url: 'ctrl/'+ctrl+'.php',
        type: 'post',
        dataType: 'json',
        data: dados
    }).done(callback);
}

function checkedLink( $link ){
    $link.parents('ul').find('a.checked').removeClass('checked');
    $link.addClass('checked');
}

function limparCampos( $form ){
    $form.find('input:not([type="hidden"]), textarea').val('');
    $form.find('select').val(0);
}

function snackBar( mensagem ){
    $.mSnackbar(mensagem);
    setTimeout(function(){
        $.mSnackbar().close();
    }, 2000);
}

function buttonLabel( $handler, label ){
    var $button;

    if( $handler.is('form') ){
        $button = $handler.find('button[type="submit"]');
    }
    else if( !$handler.is('button') ){
        $button = $handler.parents('form').find('button[type="submit"]');
    }
    else {
        $button = $handler;
    }

    $button.prop('title', label);
    $button.html(label);
}