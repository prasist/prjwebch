  // Define the tour!
    var tour = {
      id: "hello-hopscotch",
      steps: [
        {
          title: "Bem-Vindo ao Sigma3",
          content: "Criando um novo usuário. <br/><br/>Antes é necessário entender que o sistema separa os usuários por grupos, para assim facilitar as permissões de acesso que serão feitas posteriormente. Dito isso, vamos começar!",
          target: document.querySelector("#tour1"),
          placement: "right"
        },
        {
          title: "Passo 1",
          content: "Para criar um novo usuário, é preciso criar o grupo em que ele será colocado. Clique em 'Segurança' na barra lateral e, logo após, em 'Grupos de Usuário'.",
          target: document.querySelector("#tour2"),
          placement: "bottom",
          multipage: true,
              onNext: function() {
                window.location = "/webigrejas.vs2/public/grupos"
              }
        },
        {
          title: "Passo 2",
          content: "Note que já existe um grupo cadastrado chamado 'Administrador'. Ele é criado automaticamente pelo sistema. Clique em 'Novo'.",
          target: document.querySelector("#tour3"),
          placement: "bottom",
          multipage: true,
              onNext: function() {
                window.location = "/webigrejas.vs2/public/grupos/registrar"
              }
        },
        {
          title: "Passo 3",
          content: "Após informar um nome e gravar, clique em 'Grupos/Permissões' no menu 'Segurança'.",
          target: document.querySelector("#tour4"),
          placement: "bottom",
          multipage: true,
              onNext: function() {
                window.location = "/webigrejas.vs2/public/permissoes"
              }
        },
        {
          title: "Passo 4",
          content: "Após clicar em 'Novo Registro', aparecerão as permissões ACESSAR, INCLUIR, ALTERAR, EXCLUIR, VISUALIZAR, EXPORTAR ou IMPRIMIR. Defina as permissões do grupo e grave.",
          target: document.querySelector("#tour5"),
          placement: "bottom",
          multipage: true,
              onNext: function() {
                window.location = "/webigrejas.vs2/public/permissoes/registrar"
              }
        },
        {
          title: "Passo 5",
          content: "Concluído o cadastro das permissões, clique em 'Usuários',  no menu 'Segurança' e comece a cadastrar os novos usuários clicando no botão 'Novo Registro'.",
          target: document.querySelector("#tour6"),
          placement: "bottom",
          multipage: true,
              onNext: function() {
                window.location = "/webigrejas.vs2/public/usuarios"
              }
        },

        {
          title: "Passo 6",
          content: "Clique no botão 'Novo Registro' para criar um novo usuário",
          target: document.querySelector("#tour7"),
          placement: "bottom",
          multipage: true,
              onNext: function() {
                window.location = "/webigrejas.vs2/public/usuarios/registrar"
              }
        },

        {
          title: "Passo 7",
          content: "Não esqueça de fazer a escolha do Grupo do usuário de acordo com as permissões que você deseja dar a ele. Preencha as informações cadastrais do usuário e clique em 'Gravar' e pronto! O novo usuário está cadastrado. Ele poderá ter acesso ao sistema fazendo login com o e-mail e a senha cadastrados pelo administrador.",
          target: document.querySelector("#tour8"),
          placement: "bottom",
          multipage: true,
              onNext: function() {
                window.location = "/webigrejas.vs2/public/home"
              }
        }

      ]
    };