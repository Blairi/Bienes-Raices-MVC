/// <reference types="Cypress" />

describe("Prueba de Autenticación", () => {

    it("Autenticación en /login", () => {
        cy.visit("/login");

        cy.get('[data-cy="heading-login"]').should("exist");
        cy.get('[data-cy="heading-login"]').should("have.text", "Iniciar Sesión");

        cy.get('[data-cy="formulario-login"]').should("exist");

        // Ambos campos son obligatorios
        cy.get('[data-cy="formulario-login"]').submit();
        cy.get('[data-cy="alerta-login"]').should("exist");
        cy.get('[data-cy="alerta-login"]').eq(0).should("have.class", "error");
        cy.get('[data-cy="alerta-login"]').eq(0).should("have.text", "El email es obligatorio");

        cy.get('[data-cy="alerta-login"]').eq(1).should("have.class", "error");
        cy.get('[data-cy="alerta-login"]').eq(1).should("have.text", "El password es obligatorio");
        //El usuario existe
        cy.get('[data-cy="email-login"]').should('exist');
        cy.get('[data-cy="email-login"]').type('corcoro@correo.com');
        cy.get('[data-cy="password-login"]').type('123456');
 
        cy.get('[data-cy="formulario-login"]').submit();
        
        cy.get('[data-cy="alerta-login"]').eq(0).should('have.class', 'error');
        cy.get('[data-cy="alerta-login"]').eq(0).should('have.text', 'El usuario no EXISTE');
 
        //Verificar el password
 
        cy.get('[data-cy="email-login"]').type('correo@correo.com');
        cy.get('[data-cy="password-login"]').type('12345');
        
        cy.get('[data-cy="formulario-login"]').submit();
 
        cy.get('[data-cy="email-login"]').type('correo@correo.com');
        cy.get('[data-cy="password-login"]').type('123456');
 
        cy.get('[data-cy="formulario-login"]').submit();
 
        cy.get('[data-cy="heading-admin"]').should('exist');
        cy.get('[data-cy="heading-admin"]').should('have.text', 'Administrador de Bienes Raices');
 
        cy.visit('/login');

    });

});