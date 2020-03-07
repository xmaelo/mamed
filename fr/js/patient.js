$(document).ready(function () {
    load(1);
});

function load(page) {
    var q = $("#q").val();
    var select_filtre_autre = $("#select_filtre_autre").val();
    var filtre = $("#filtre").val();
   //console.log(filtre);
    var date_debut = $('#date_debut').val();
    var date_fin = $('#date_fin').val();
    var parametres = {
        'action': 'ajax', 'page': page, 'q': q, 'date_debut': date_debut, 'date_fin': date_fin,
        'select_filtre_autre': select_filtre_autre, 'filtre': filtre
    };
    $("#loader").fadeIn('slow');
    $.ajax({
        data: parametres,
        url: './ajax/rechercher_patient.php',
        beforeSend: function (objet) {
            $('#loader').html('<img src="./img/ajax-loader.gif"> Chargement...');
        },
        success: function (data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');

        }
    });
}

                function clara() {
                    var data = $('#filtre').val();
                    console.log(data);
                   
                
                    }
                   
                













$("#form_nouveau_patient").submit(function (event) {
    $('#btn_save_patient').attr("disabled", true);

    var parametres = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/nouveau_patient.php",
        data: parametres,
        beforeSend: function (objet) {
            $("#resultat_ajax").html("Message: Chargement...");
        },
        success: function (data) {
            $("#resultat_ajax").html(data);
            if (data.indexOf('alert-danger') == -1) {
                $("#form_nouveau_patient")[0].reset();
                window.setTimeout(function () {
                    $(".alert").fadeTo(200, 0).slideUp(500, function () {
                        $(this).remove();
                    });
                    location.replace('patients.php');
                }, 3000);
            }
            $('#btn_save_patient').attr("disabled", false);

            load(1);
        }
    });
    event.preventDefault();
})

$('#form_editer_patienttt').on('submit', function (e) {
    // On empêche le navigateur de soumettre le formulaire
    e.preventDefault();

    var $form = $(this);
    var formdata = (window.FormData) ? new FormData($form[0]) : null;
    var data = (formdata !== null) ? formdata : $form.serialize();
    var vrai = true;

    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        contentType: false, // obligatoire pour de l'upload
        processData: false, // obligatoire pour de l'upload
        dataType: 'json', // selon le retour attendu
        data: data,
        success: function (i) {

            if (i == '') {
                window.location.reload();
            } else {
            }
        },

    });


});


$('#modal_editer_patient').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var idpatient = button.data('idpatient')
    var idtype_diabete = button.data('idtype_diabete')
    var idpersonne = button.data('idpersonne')
    var nom = button.data('nom')
    var prenom = button.data('prenom')
    var adresse = button.data('adresse')
    var datenaiss = button.data('datenaiss')
    var sexe = button.data('sexe')
    var email = button.data('email')
    var telephone1 = button.data('telephone1')
    var telephone2 = button.data('telephone2')
    var poids = button.data('poids')
    var taille = button.data('taille')
    var personne_urgence = button.data('personne_urgence')
    var telephone_urgence = button.data('telephone_urgence')
    var appelant = button.data('appelant')
    var chemin = button.data('chemin')

    var modal = $(this)
    modal.find('.modal-body #mod_idpatient').val(idpatient)
    modal.find('.modal-body #mod_idpersonne').val(idpersonne)
    modal.find('.modal-body #mod_idtype_diabete').val(idtype_diabete)
    modal.find('.modal-body #mod_nom').val(nom)
    modal.find('.modal-body #mod_prenom').val(prenom)
    modal.find('.modal-body #mod_datenaiss').val(datenaiss)
    modal.find('.modal-body #mod_adresse').val(adresse)
    modal.find('.modal-body #mod_sexe').val(sexe)
    modal.find('.modal-body #mod_telephone1').val(telephone1)
    modal.find('.modal-body #mod_telephone2').val(telephone2)
    modal.find('.modal-body #mod_poids').val(poids)
    modal.find('.modal-body #mod_taille').val(taille)
    modal.find('.modal-body #mod_personne_urgence').val(personne_urgence)
    modal.find('.modal-body #mod_telephone_urgence').val(telephone_urgence)
    modal.find('.modal-body #mod_appelant').val(appelant)
    modal.find('.modal-body #mod_chemin').val(chemin);
})


$('.datepicker').datepicker({
    autoclose: true,
    language: 'fr'
});


$('.close_form').on('click', function (e) {

    $("#form_nouveau_patient")[0].reset();
    $('#form_editer_patient')[0].reset();
})


//traitement des regions pour avoir les departements

