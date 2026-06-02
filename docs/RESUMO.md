# O que foi feito no AgendaFácil

## Cadastro e login

No registro, a pessoa escolhe se é **Cliente** ou **Profissional**. Isso define o que ela vê no sistema depois de entrar.

---

## Tela de Serviços (só profissional)

Foi criada a página **Serviços**, onde o profissional cadastra o que oferece (corte, consulta, etc.).

- Lista os serviços já cadastrados, com duração e preço quando informados.
- Botão **Novo Serviço** abre um modal para preencher: nome, duração em minutos, descrição e preço (estes dois últimos são opcionais).
- Ao salvar, a lista atualiza na hora, sem recarregar a página, e aparece uma mensagem de sucesso.
- Cliente **não** acessa essa tela.

---

## Tela de Agendamentos

Página **Agendamentos** para ver as consultas marcadas.

- **Cliente:** vê seus agendamentos (serviço, data, hora e nome do profissional) e pode clicar em **Novo Agendamento**.
- **Profissional:** vê os agendamentos dele (serviço, data, hora e nome do cliente).

No modal de novo agendamento (cliente), escolhe o profissional, depois o serviço (só os daquele profissional), a data e a hora. O sistema só aceita se o horário ainda estiver livre e não tiver passado.

---

## Dashboard (Início)

Tela inicial após o login, com menu lateral: Início, Serviços (profissional), Agendamentos.

Por enquanto mostra poucos números reais (ex.: quantidade de serviços do profissional). Outras estatísticas ainda serão preenchidas depois.

---

## O que roda “por trás” (sem tela pronta ainda)

- **Horários de trabalho:** já existe a estrutura no banco e a lógica para calcular horários livres, mas a tela para o profissional configurar a semana ainda não foi finalizada.
- **Menu Horários** no lateral ainda não leva a uma página funcional.

---