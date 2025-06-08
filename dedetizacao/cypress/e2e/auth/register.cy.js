describe('Cadastro de usuário', () => {
  it('deve cadastrar um novo usuário', () => {
    cy.visit('/register');
    cy.get('input[name=name]').type('Novo Usuário');
    cy.get('input[name=address]').type('Rua Exemplo, 123');
    cy.get('input[name=email]').type('novo@exemplo.com');
    cy.get('input[name=password]').type('senha123');
    cy.get('input[name=password_confirmation]').type('senha123');
    cy.get('button[type=submit]').click();
    cy.url().should('include', '/home');
  });
});
