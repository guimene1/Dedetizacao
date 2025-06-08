describe('Login de usuário', () => {
  it('deve exibir erro se os campos estiverem vazios', () => {
    cy.visit('/login');
    cy.get('button[type=submit]').click();
    cy.contains('O campo e-mail é obrigatório').should('exist');
  });

  it('deve permitir login com credenciais válidas', () => {
    cy.visit('/login');
    cy.get('input[name=email]').type('admin@example.com');
    cy.get('input[name=password]').type('senha123');
    cy.get('button[type=submit]').click();
    cy.url().should('include', '/home');
  });
});
