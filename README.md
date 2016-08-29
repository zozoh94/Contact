# Contact
This form contact need PHPMailer and toastr.
HTML form example to work with (in jade):

.content-section-a#contact
  .container
    .row
      .col-lg-12
        h2.section-heading Nous contacter
        form.form-horizontal(role="form", action="contact.php", method="post")
          .form-group
            label.col-sm-2.control-label(for="prenomContact") Prénom
            .col-sm-10
              input.form-control#prenomContact(placeholder="Pierre", type="text", name="prenom", required)
          .form-group
            label.col-sm-2.control-label(for="nomContact") Nom
            .col-sm-10
              input.form-control#nomContact(placeholder="Martin", type="text", name="nom", required)
          .form-group
            label.col-sm-2.control-label(for="emailContact") Email
            .col-sm-10
              input.form-control#emailContact(placeholder="pierre.martin@exemple.fr", name="email", type="email", required)
          .form-group
            label.col-sm-2.control-label(for="messageContact") Message
            .col-sm-10
              textarea.form-control#messageContact(placeholder="Votre message ici...", name="message", rows="5", required)
          .form-group
            .col-sm-10.col-sm-offset-2
              .g-recaptcha(data-sitekey="6Lch_RkTAAAAAKoXeyM855MPfD1GrZlcezThJmR9")
          .form-group
            .col-sm-10.col-sm-offset-2
              button.btn.btn-primary(type="submit") 
                span.fa.fa-send
                |  Envoyer
