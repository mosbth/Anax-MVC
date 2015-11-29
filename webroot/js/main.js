$( document ).ready(function () {
    'use strict';
    console.log( "ready!" );
    
    $("#errormessage").show();
    setTimeout(function () {
    $("#errormessage").slideUp(); }, 3500);
    $("#successmessage").show();
    setTimeout(function () {
        $("#successmessage").slideUp(); }, 3500);
    
    $(".tagsinput").tagsinput({
        maxTags: 3,
        trimValue: true
    });
    
$( "#tabs" ).tabs();
    
    
$('#adduser')
    .formValidation({
        framework: 'bootstrap',
        button: {
            selector: '#validateButton',
            disabled: 'disabled'
        },
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
    locale: 'sv_SE',
        fields: {
            name:{
                validators:{
                    notEmpty:{
                    },
                    stringLength: {
                        min: 4,
                        max: 30,
                    },
                    regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'Ditt namn kan bara bestå av bokstäver.'
                    }
                }
            },
            email:{
                validators:{
                    notEmpty:{
                    },
                    emailAddress: {
                    }
                }
            },
            acronym: {
                validators: {
                    notEmpty:{
                        message: 'Du måste välja användarnamn'
                    },
                    stringLength: {
                        min: 4,
                        max: 20,
                        message: 'Användarnamnet måste vara mellan 4-20 bokstäver långt'
                    },
                    regexp: {
                        regexp:/^[a-öA-Ö0-9_]+$/,
                        message: 'Användarnamnet kan bara innehålla A-Ö, siffror eller _'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Du måste fylla i ett lösenord'
                    },
                    stringLength: {
                        min: 4,
                        message: 'Lösenordet måste vara minst 6 bokstäver långt'
                    }
                }
            },
            about: {
                validators: {
                    notEmpty: {
                        message: 'Du måste fylla i det här fältet'
                    }
                }
            },
            website: {
                validators: {
                    uri: {
                    }
                }
            },
            villkor: {
                validators:{
                    notEmpty:{
                        message: 'Du måste godkänna villkoren'
                    }
                }
            }//END OF VILLKOR
        }//END OF FIELDS
    });//END OF FORMVALIDATION ADD USER

    
    $("#loginfirstpage").formValidation({
        framwork: 'bootstrap', 
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            acronym: {
                validators: {
                    notEmpty: {
                        message: 'Du måste fylla i användarnamn'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Du måste fylla i ett lösenord'
                    }, 
                    stringLength: {
                        min:4,
                        message: 'För kort lösenord'
                    }
                }
            }
        }
    });
            

});