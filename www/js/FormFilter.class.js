"use strict";

/*
 N° de Téléphone -> max 10, entier positif uniquement
 zip code        -> max 5, entier positif uniquement
 email           -> recquis, doit un @ et un . avec du texte entre les deux
 mot de passe    -> recquis, minimum 6
 */

var FormFilter = function ($form) {
    this.$form = $form;
    this.$errorMessage = $(".errors");
    this.errors = [];

};


FormFilter.prototype.checkLength = function () {
    var maxLength, minLength, length;

    $('[data-min]').each(function (key, input) {
        minLength = parseInt($(input).data('min'));
        length = $(input).val().length;

        // on vérifie que le champ n'est pas vide et que la longueur est ok
        if (length && length < minLength) {
            this.errors.push('le champ <strong>' + input.dataset.name + '</strong> doit faire au minimum ' + minLength + ' caractère(s)');
        }
    }.bind(this));

    $('[data-max]').each(function (key, input) {
        maxLength = parseInt($(input).data('max'));
        length = $(input).val().length;

        // on vérifie que le champ n'est pas vide et que la longueur est ok
        if (length && length > maxLength) {
            this.errors.push('le champ <strong>' + input.dataset.name + '</strong> doit faire au maximum ' + maxLength + ' caractère(s)');
        }
    }.bind(this));
};

FormFilter.prototype.checkType = function () {
    var value, regexp;

    $('[data-type]').each(function (key, input) {
        value = $(input).val();

        // On passe au each suivant si le champ est vide "".
        if (!value)
            return;

        switch ($(input).data('type')) {
            case 'positive-integer':
                if (isNaN(value) || value < 0 || value % 1 !== 0)
                    this.errors.push('le champ <strong>' + input.dataset.name + '</strong> doit être un entier positif');
                break;
            case 'email':

                var regexp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                //regexp = /^[\w-]+@[\w-]+.[a-z.]{2,6}$/;

                if (!value.match(regexp))
                    this.errors.push('le champ <strong>' + input.dataset.name + '</strong> doit être au format email');
                break;
            case 'password':
                regexp = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{4,}$/

                if (!value.match(regexp))
                    this.errors.push('le champ <strong>' + input.dataset.name + '</strong> doit contenir 1 majuscule, 1 chiffre et 1 caractère spécial');
                break;
        }

        var maxLength = parseInt($(input).data('max'));
        var length = $(input).val().length;
        if (length > maxLength) {
            this.errors.push('le champ <strong>' + input.dataset.name + '</strong> doit faire au maximum ' + maxLength + ' caractère(s)');
        }
    }.bind(this));

};

FormFilter.prototype.checkRequired = function () {

    $('[data-required]').each(function (key, input) {

        if ($(input).val().length === 0) {
            this.errors.push('le champ <strong>' + input.dataset.name + '</strong> est requis');
        }

    }.bind(this));
};

FormFilter.prototype.displayErrors = function () {

    var errorHtml = '';

    for (var errorIndex in this.errors) {
        if (this.errors.hasOwnProperty(errorIndex)) {
            errorHtml += this.errors[errorIndex] + '<br>';
        }
    }
    console.log($('.errors'));
    this.$errorMessage.find('p').empty().append(errorHtml);
    this.$errorMessage.fadeIn();
};

FormFilter.prototype.checkForms = function () {
    this.errors = [];

    // data-required
    this.checkRequired();

    // data-min / data-max
    this.checkLength();

    // data-type(email, phone, positive-integer, date...)
    this.checkType();
    if (this.errors.length) {
        this.displayErrors();
        event.preventDefault();
    }
};


FormFilter.prototype.run = function () {

    this.$form.submit(
        function () {
            this.checkForms();
            console.log("test")
        }.bind(this)
    );
};


