
(function () {
    'use strict';
    window.addEventListener('load', function () {
        let forms = document.getElementsByClassName('needs-validation');
        let validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });


        $('#deleteModal, #switchModal').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let id = button.data('id');
            let name = button.data('name');
            let modal = $(this);
            modal.find('.modal-body input#id').val(id);
            modal.find('.modal-body #name').text(name);
        });

        $('.edit-button').on('click touch', function (event) {
            event.preventDefault();

            let button = $(this);
            let id = button.data('id');
            let name = button.data('name');
            let email = button.data('email');
            let text = button.data('text');
            let target = $(button.data('target'));
            target.find('input#id').val(id);
            target.find('input#name').val(name);
            target.find('input#email').val(email);
            target.find('textarea#text').text(text);

            let offset = $(target).offset().top - 40;
            $('html, body').animate({ scrollTop: offset }, 100);

        });

    }, false);
})();