jQuery(document).ready(function() {
    // Gestion des toasts
    var elements = document.getElementsByClassName('content');

    if (elements.length > 0 && elements[0].className.match(/hide/) === null) {
        new bootstrap.Toast(document.getElementById('toast')).show();
    }
    if (elements.length > 1 && elements[1].className.match(/hide/) === null) {
        new bootstrap.Toast(document.getElementById('toast2')).show();
    }
    if (elements.length > 2 && elements[2].className.match(/hide/) === null) {
        new bootstrap.Toast(document.getElementById('toast3')).show();
    }
});

jQuery(function($) {
    $('#exportCSV').on('click', function(e) {
        $('#usedTable').tableExport(
            {
                type:'csv',
                csvSeparator: ';',
                fileName: 'Export_of_used_on'
            }
        );    
    });
    
    // Bouton de MAJ du cache
    $('#majCache').on('click', function(e) {
        var params = {
            'action': 'maj',
        };
        
        var message = 'Veuillez patienter pendant la mise à jour du cache...<br>Cela peut prendre plusieurs minutes...<br><strong>Merci de ne pas fermer et/ou recharger cette page en attendant !</strong>';
        
        var html = '<style type="text/css">div.blackbackgroundtoast{z-index:10000;opacity:90%;}div.blackbackgroundtoast > div.top-25 {top:25% !important;}</style>';
        html += '<div aria-live="polite" aria-atomic="true" class="bg-dark position-absolute blackbackgroundtoast w-100 h-100 top-0 start-0">';
        html += '<div class="toast-container position-absolute top-25 start-50 translate-middle p-3"><div class="toast" id="toast5" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">';
        html += '<div class="toast-header bg-primary text-white"><strong class="me-auto">Mise à jour du cache</strong>';
        html += '<button type="button" class="btn-close" data-bs-dismiss="toast"></button>';
        html += '</div><div class="toast-body text-center"><span class="dashicons dashicons-update" style="width: 50px;height: 50px;font-size: 50px;margin: 0 auto;"></span><br>' + message + '</div></div></div></div>';
        
        $('.content.ppgbo-cache form').prepend(html);
        
        $('.content.ppgbo-cache form').on('click', '#toast5 .btn-close', function(e) {
            //$('.blackbackgroundtoast').remove();
            location.reload();
        });
        
        new bootstrap.Toast(document.getElementById('toast5')).show();
        
        $.post(ppgbo_ajax.url, params, function(response) {
            $('#toast5 .toast-body').html(response);
        }); 
    });
    
    // Bouton de RAZ du cache
    $('#razCache').on('click', function(e) {
        var params = {
            'action': 'raz',
        };
        
        var html = '<div class="toast-container position-absolute top-0 end-0 p-3"><div class="toast" id="toast4" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">';
        html += '<div class="toast-header bg-danger text-white"><strong class="me-auto">Suppression du cache</strong>';
        html += '<button type="button" class="btn-close" data-bs-dismiss="toast"></button>';
        html += '</div><div class="toast-body">Chargement en cours</div></div></div>';
        
        $('.content.ppgbo-cache form').prepend(html);
        
        new bootstrap.Toast(document.getElementById('toast4')).show();
        
        $.post(ppgbo_ajax.url, params, function(response) {
            $('#toast4 .toast-body').html(response);
        }); 
    });
});