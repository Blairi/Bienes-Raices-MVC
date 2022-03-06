/// <reference types="Cypress" />
describe("Prueba el formulario de Contacto", () => {
    it("Prueba la página de contacto y el envio de e-mail", () => {
        cy.visit("/contacto");

        cy.get('[data-cy="heading-contacto"]').should("exist");
        cy.get('[data-cy="heading-contacto"]').invoke("text").should("equal", "Contacto");
        cy.get('[data-cy="heading-contacto"]').invoke("text").should("not.equal", "Formulario-Contacto");

        cy.get('[data-cy="heading-formulario"]').should("exist");
        cy.get('[data-cy="heading-formulario"]').invoke("text").should("equal", "Llene el Formulario de Contacto");
        cy.get('[data-cy="heading-formulario"]').invoke("text").should("not.equal", "formulario de Contacto");

        cy.get('[data-cy="formulario-contacto"]').should("exist");
    });

    it("LLena campos de formulario", () => {
        cy.get('[data-cy="input-nombre"]').type("Axel");
        cy.get('[data-cy="input-mensaje"]').type("Hola, quiero comprar una casa al lado del mar");
        cy.get('[data-cy="input-opciones"]').select("Compra");

        cy.get('[data-cy="input-precio"]').type("12000")

        cy.get('[data-cy="forma-contacto"]').eq(1).check();

        cy.wait(3000);

        cy.get('[data-cy="forma-contacto"]').eq(0).check();

        cy.get('[data-cy="input-telefono"]').type("5544332211");
        cy.get('[data-cy="input-fecha"]').type("2022-03-06");
        cy.get('[data-cy="input-hora"]').type("12:30");

        cy.get('[data-cy="formulario-contacto"]').submit();

        cy.get('[data-cy="alerta-envia-formulario"]').should("exist");
        cy.get('[data-cy="alerta-envia-formulario"]').invoke("text").should("equal", "Mensaje Enviado Correctamente");
        cy.get('[data-cy="alerta-envia-formulario"]').should("have.class", "alerta").and("have.class", "exito").and("not.have.class", "error");
    });
});