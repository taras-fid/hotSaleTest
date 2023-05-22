$(function() {

    function validateEmail(email) {
        const re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

    function showError(message) {
        $('#error-message').text(message).show();
        $('#success-message').hide();
    }

    function showSuccess(message) {
        $('#success-message').text(message).show();
        $('#error-message').hide();
    }

    $('#register-form').submit(function(e) {
        e.preventDefault();

        let name = $('#name').val();
        let surname = $('#surname').val();
        let email = $('#email').val();
        let password = $('#password').val();
        let confirmPassword = $('#confirm-password').val();

        if (!validateEmail(email)) {
            showError('Некоректний email');
            return;
        }

        if (password !== confirmPassword) {
            showError('Паролі не співпадають');
            return;
        }

        $.ajax({
            url: 'index.php',
            type: 'POST',
            data: {
                name: name,
                surname: surname,
                email: email,
                password: password,
                confirmPassword: confirmPassword
            },
            success: function(response) {
                if (response === 'success') {
                    showSuccess('Ви успішно зареєстровані!');
                    $('.registration-form').hide();
                } else {
                    showError('Трапилась помилка при реєстрації');
                }
            },
            error: function() {
                showError('Помилка сервера');
            }
        });
    });
});
