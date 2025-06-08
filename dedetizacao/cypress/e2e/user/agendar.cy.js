describe('Agendamento', () => {
  beforeEach(() => {
    cy.login('usuario@example.com', 'senha123'); // comando customizado
    cy.visit('/agendar');
  });

  it('deve exibir erro se data não for preenchida', () => {
    cy.get('button[type=submit]').click();
    cy.contains('A data do agendamento é obrigatória').should('exist');
  });

  it('deve agendar com sucesso', () => {
    const dataFutura = Cypress.dayjs().add(5, 'day').format('YYYY-MM-DD');
    cy.get('input[name=data]').type(dataFutura);
    cy.get('select[name=tipo_peste]').select('roedores');
    cy.get('button[type=submit]').click();
    cy.contains('Agendamento realizado com sucesso').should('exist');
  });
});
