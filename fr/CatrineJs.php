<?php

if ($lang['langue'] == 'Fr'): ?>
    <script type="text/javascript">
        function elimina(id) {
            var q = $("#q").val();
            if (confirm('Voulez vous supprimer ce patient?')) {
                $.ajax({
                    type: "GET",
                    url: "./ajax/rechercher_patient.php",
                    data: "id=" + id, "q": q,
                    beforeSend: function (objet) {
                        $("#resultats").html("Message: Chargement...");
                    },
                    success: function (data) {
                        $("#resultats").html(data);
                        load(1);
                    }
                });
            }
        }
    </script>


    <script>
        $("#region_patient").on('change', function (e) {
            var idregion = $(this).val();
            $.ajax({
                dataType: 'JSON',
                url: 'ajax/get_departement.php?idregion=' + idregion,

                beforeSend: function (object) {
                    $('#loader_departement').html('<img src="./img/ajax-loader.gif"> '+chargement);
                },
                success: function (data) {
                    $('#departement_patient').empty();
                    $('#departement_patient').append("<option disabled selected>Choisir un département</option>");
                    $.each(data, function (id, label) {
                        $('#departement_patient').append('<option value="' + id + '">' + label + '</option>');
                    });
                    $('#loader_departement').html("");
                }
            });
        });

        //traitement des département pour avoir les arrondissements

        $("#departement_patient").on('change', function (e) {
            var iddepartement = $(this).val();
            $.ajax({
                data: 'iddepartement=' + iddepartement,
                dataType: 'JSON',
                url: 'ajax/get_arrondissement.php',

                beforeSend: function (object) {
                    $('#loader_arrondissement').html('<img src="./img/ajax-loader.gif"> '+chargement);
                },
                success: function (data) {
                    $('#arrondissement_patient').empty();
                    $('#arrondissement_patient').append("<option disabled selected>Choisir un arrondissement</option>");
                    $.each(data, function (id, label) {
                        $('#arrondissement_patient').append('<option value="' + id + '">' + label + '</option>');
                    });
                    $('#loader_arrondissement').html("");

                }
            });
        });

        //traitement du filtre
        $('#select_filtre_autre').on('change', function (e) {
            var param = $('#filtre').val();
            var valeur = $("#select_filtre_autre").val();
            $('#btn_imprimer').attr("href", "imprimer.php?param=" + param + "&valeur=" + valeur);
        })

        $('#filtre').on('change', function (event) {
            var filtre = $(this).val();
            //alert(filtre); 
            if (filtre == 'datenaiss') {
                $('#filtre_date').show();
                $('#filtre_autre').hide(); 
            } else {
                $('#filtre_date').hide();
                $('#filtre_autre').show();
                $.ajax({
                    url: './ajax/get_data_filtre.php?data=' + filtre,
                    dataType: 'JSON',

                    beforeSend: function (object) {
                        $('#loader').html('<img src="./img/ajax-loader.gif"> '+chargement);
                    },
                    success: function (data) {
                        $('#select_filtre_autre').empty();
                        $('#select_filtre_autre').append("<option disabled selected>Sélectionner</option>");
                        $.each(data, function (id, label) {
                            console.log(label);
                            $('#select_filtre_autre').append('<option value="' + id + '">' + label + '</option>');
                        });
                        $('#loader').html("");
                    }
                });
            }
            event.preventDefault();
        });

        $('#btn_search').on('click', function (e) {
            var debut = $('#date_debut').val();
            var fin = $('#date_fin').val();

            if (debut && fin) {

                if (debut > fin) {

                    alert("Date de debut supérieur à la date de fin");

                } else {

                    load(1);
                    $('#btn_imprimer').attr("href", "imprimer.php?debut=" + debut + "&fin=" + fin);
                }
            } else {

                alert("Date de debut invalide");
            }

            e.preventDefault();

        });
    </script>


<?php elseif ($lang['langue'] == 'Eng'): ?>


    <script type="text/javascript">
        function elimina(id) {
            var q = $("#q").val();
            if (confirm('Do you want to delete this patient?')) {
                $.ajax({
                    type: "GET",
                    url: "./ajax/rechercher_patient.php",
                    data: "id=" + id, "q": q,
                    beforeSend: function (objet) {
                        $("#resultats").html("Message: Chargement...");
                    },
                    success: function (data) {
                        $("#resultats").html(data);
                        load(1);
                    }
                });
            }
        }
    </script>


    <script>
        $("#region_patient").on('change', function (e) {
            var idregion = $(this).val();
            $.ajax({
                dataType: 'JSON',
                url: 'ajax/get_departement.php?idregion=' + idregion,

                beforeSend: function (object) {
                    $('#loader_departement').html('<img src="./img/ajax-loader.gif"> '+chargement);
                },
                success: function (data) {
                    $('#departement_patient').empty();
                    $('#departement_patient').append("<option disabled selected> Choose a department</option>");
                    $.each(data, function (id, label) {
                        $('#departement_patient').append('<option value="' + id + '">' + label + '</option>');
                    });
                    $('#loader_departement').html("");
                }
            });
        });

        //traitement des département pour avoir les arrondissements

        $("#departement_patient").on('change', function (e) {
            var iddepartement = $(this).val();
            $.ajax({
                data: 'iddepartement=' + iddepartement,
                dataType: 'JSON',
                url: 'ajax/get_arrondissement.php',

                beforeSend: function (object) {
                    $('#loader_arrondissement').html('<img src="./img/ajax-loader.gif"> '+chargement);
                },
                success: function (data) {
                    $('#arrondissement_patient').empty();
                    $('#arrondissement_patient').append("<option disabled selected>Choose a borough</option>");
                    $.each(data, function (id, label) {
                        $('#arrondissement_patient').append('<option value="' + id + '">' + label + '</option>');
                    });
                    $('#loader_arrondissement').html("");

                }
            });
        });

        //traitement du filtre
        $('#select_filtre_autre').on('change', function (e) {
            var param = $('#filtre').val();
            var valeur = $("#select_filtre_autre").val();
            $('#btn_imprimer').attr("href", "imprimer.php?param=" + param + "&valeur=" + valeur);
        })

        $('#filtre').on('change', function (event) {
            var filtre = $(this).val();
            //alert(filtre);
            if (filtre == 'datenaiss') {
                $('#filtre_date').show();
                $('#filtre_autre').hide();
            } else {
                $('#filtre_date').hide();
                $('#filtre_autre').show();
                $.ajax({
                    url: './ajax/get_data_filtre.php?data=' + filtre,
                    dataType: 'JSON',

                    beforeSend: function (object) {
                        $('#loader').html('<img src="./img/ajax-loader.gif"> '+chargement);
                    },
                    success: function (data) {
                        $('#select_filtre_autre').empty();
                        $('#select_filtre_autre').append("<option disabled selected>Select</option>");
                        $.each(data, function (id, label) {
                            $('#select_filtre_autre').append('<option value="' + id + '">' + label + '</option>');
                        });
                        $('#loader').html("");
                    }
                });
            }
            event.preventDefault();
        });

        $('#btn_search').on('click', function (e) {
            var debut = $('#date_debut').val();
            var fin = $('#date_fin').val();

            if (debut && fin) {

                if (debut > fin) {

                    alert("Start date greater than the end date");

                } else {

                    load(1);
                    $('#btn_imprimer').attr("href", "imprimer.php?debut=" + debut + "&fin=" + fin);
                }
            } else {

                alert("Invalid start date");
            }

            e.preventDefault();

        });
    </script>


<?php elseif ($lang['langue'] == 'Deutch'): ?>


    <script type="text/javascript">
        function elimina(id) {
            var q = $("#q").val();
            if (confirm('Möchten Sie diesen Patienten löschen?')) {
                $.ajax({
                    type: "GET",
                    url: "./ajax/rechercher_patient.php",
                    data: "id=" + id, "q": q,
                    beforeSend: function (objet) {
                        $("#resultats").html("Message: Chargement...");
                    },
                    success: function (data) {
                        $("#resultats").html(data);
                        load(1);
                    }
                });
            }
        }
    </script>


    <script>
        $("#region_patient").on('change', function (e) {
            var idregion = $(this).val();
            $.ajax({
                dataType: 'JSON',
                url: 'ajax/get_departement.php?idregion=' + idregion,

                beforeSend: function (object) {
                    $('#loader_departement').html('<img src="./img/ajax-loader.gif"> '+chargement);
                },
                success: function (data) {
                    $('#departement_patient').empty();
                    $('#departement_patient').append("<option disabled selected> Wählen Sie eine Abteilung aus</option>");
                    $.each(data, function (id, label) {
                        $('#departement_patient').append('<option value="' + id + '">' + label + '</option>');
                    });
                    $('#loader_departement').html("");
                }
            });
        });

        //traitement des département pour avoir les arrondissements

        $("#departement_patient").on('change', function (e) {
            var iddepartement = $(this).val();
            $.ajax({
                data: 'iddepartement=' + iddepartement,
                dataType: 'JSON',
                url: 'ajax/get_arrondissement.php',

                beforeSend: function (object) {
                    $('#loader_arrondissement').html('<img src="./img/ajax-loader.gif"> '+chargement);
                },
                success: function (data) {
                    $('#arrondissement_patient').empty();
                    $('#arrondissement_patient').append("<option disabled selected> Wählen Sie einen Bezirk aus</option>");
                    $.each(data, function (id, label) {
                        $('#arrondissement_patient').append('<option value="' + id + '">' + label + '</option>');
                    });
                    $('#loader_arrondissement').html("");

                }
            });
        });

        //traitement du filtre
        $('#select_filtre_autre').on('change', function (e) {
            var param = $('#filtre').val();
            var valeur = $("#select_filtre_autre").val();
            $('#btn_imprimer').attr("href", "imprimer.php?param=" + param + "&valeur=" + valeur);
        })

        $('#filtre').on('change', function (event) {
            var filtre = $(this).val();
            //alert(filtre);
            if (filtre == 'datenaiss') {
                $('#filtre_date').show();
                $('#filtre_autre').hide();
            } else {
                $('#filtre_date').hide();
                $('#filtre_autre').show();
                $.ajax({
                    url: './ajax/get_data_filtre.php?data=' + filtre,
                    dataType: 'JSON',

                    beforeSend: function (object) {
                        $('#loader').html('<img src="./img/ajax-loader.gif"> '+chargement);
                    },
                    success: function (data) {
                        $('#select_filtre_autre').empty();
                        $('#select_filtre_autre').append("<option disabled selected>Wählen</option>");
                        $.each(data, function (id, label) {
                            $('#select_filtre_autre').append('<option value="' + id + '">' + label + '</option>');
                        });
                        $('#loader').html("");
                    }
                });
            }
            event.preventDefault();
        });

        $('#btn_search').on('click', function (e) {
            var debut = $('#date_debut').val();
            var fin = $('#date_fin').val();

            if (debut && fin) {

                if (debut > fin) {

                    alert("Startdatum ist größer als das Enddatum");

                } else {

                    load(1);
                    $('#btn_imprimer').attr("href", "imprimer.php?debut=" + debut + "&fin=" + fin);
                }
            } else {

                alert("Ungültiges Startdatum");
            }

            e.preventDefault();

        });
    </script>


<?php endif; ?>










 




















