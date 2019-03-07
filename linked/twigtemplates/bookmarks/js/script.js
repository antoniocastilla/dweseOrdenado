(function() {

    var editing = false;
    var tituloOk = false;

    var genericAjax = function(url, data, type, callBack) {
        $.ajax({
                url: url,
                data: data,
                type: type,
                dataType: 'json',
            })
            .done(function(json) {
                console.log('AJAX POWER...');
                console.log(json);
                callBack(json);
                reasignaEventos();
            })
            .fail(function(xhr, status, errorThrown) {
                console.log('AJAX: Fail');
            })
            .always(function(xhr, status) {
                console.log('AJAX: Always');
            });
    }

    var getLinks = function(pagina = 1) {
        genericAjax('ajax/listalinks', {'pagina':pagina}, 'get', function(json) {
            procesarLinks(json);
            //procesarPaginas(json.paginas);
        });
    }
    
    var getCategories = function() {
        genericAjax('ajax/listacategories', {}, 'get', function(json) {
            console.log('Categorias: ' + json);
            procesarCategories(json);
        });
        getLinks();
    }

    var getDivLink = function(value, categories, loopIndex) {
        var element = `
            <div class="card-container">
				<div class="card u-clearfix">
					<div class="card-body">
						<span class="card-number card-circle subtle">${value.link.id}</span>
						<select name="newCategory" id="newCat">
    				     <option value="0">No category</option>`;

        categories.forEach(function(cat, index) {
            if (cat.id === value.categoriaid) {
                element += `<option value="${cat.id }" selected>${cat.nombre}</option>`;
            }
            else {
                element += `<option value="${cat.id }">${cat.nombre}</option>`;
            }
        })
        element += `    </select>
						<h2 class="card-title editable">${value.link.title}</h2>
						<span class="card-description subtle editable">${value.link.comentario}</span>
						<div class="card-read"><a href="${value.link.href}" target="_onblank">Visit</a></div>
						<span class="card-tag card-circle subtle"><a href="#" class="delete-link" data-id="${value.link.id}">X</a></span>
					</div>
					<img src="https://loremflickr.com/300/400/tumblr?random=${loopIndex}" alt="" class="card-media" />
				</div>
				<div class="card-shadow"></div>
			</div>
        `;
        return element;
    }
    
    var getDivCategory = function(value, loopIndex) {
        var element = `
            <div class="singlecategory">
				<a href="#" class="single-cat">${value.nombre}</a>
				<a href="#" class="delete-cat" id="delete-cat" data-id="${value.id}">X</a>
			</div>
        `;
        return element;
    }


    var procesarLinks = function(json) {
        var listaitems = '';
        var loopIndex = 0;
        $.each(json.links, function(key, value) {
            listaitems += getDivLink(value, json.categories, loopIndex);
            loopIndex++;
        });

        $('#cuerpoLinks').empty();
        //console.log(listaitems);
        $(listaitems).hide().appendTo('#cuerpoLinks').fadeIn(1000);
        $('#cuerpoLinks .borrar').on('click', function(e) {
            var parametros;
            if (confirm('¿Seguro que quieres borrar?')) {
                var id = $(this).closest('.row').data('idcancion');
                parametros = { 'id': id };
                console.log('Parametros: ');
                console.log(parametros);
                genericAjax('ajax/deleteLink', parametros, 'post', getLinks());
            }
        })
    }
    
    var procesarCategories = function (json) {
        var listaitems = `
            <div class="newsinglecategory" id="newsinglecategory">
    				<input type="text" name="newcategoryname" required>
    				<a href="#" class="add-cat" id="add-cat">&#10010;</a>
    		</div>
            `;
        var loopIndex = 0;
        $.each(json.categories, function(key, value) {
            listaitems += getDivCategory(value, loopIndex);
            loopIndex++;
        });

        $('#cuerpoCategories').empty();
        //console.log(listaitems);
        $(listaitems).hide().appendTo('#cuerpoCategories').fadeIn(1000);
        $('#cuerpoCategories .borrar').on('click', function(e) {
            var parametros;
            if (confirm('¿Seguro que quieres borrar?')) {
                var id = $(this).closest('.row').data('idcancion');
                parametros = { 'id': id };
                console.log('Parametros: ');
                console.log(parametros);
                genericAjax('ajax/deleteLink', parametros, 'post', getLinks());
            }
        })
    }

    $(document).ajaxStart(function() {
        console.log('pre shadow');
        $('#loading').show();
    });

    $(document).ajaxStop(function() {
        console.log('post shadow');
        $('#loading').hide();
    });

    $('div.card-read #btRegister').on('click', evento_btRegister);
    function evento_btRegister (event) {
        var parametros
        event.preventDefault();
        parametros = {
            title: $('#newTitle').val().trim(),
            href: $('#newHref').val().trim(),
            comentario: $('#newComment').val().trim(),
            newCategory: $('#newCat').val(),
        };
        if (parametros.title !== '' &&
            parametros.href !== '') {
            console.log(parametros);
            genericAjax('ajax/register', parametros, 'post', function(json) {
                if (json.register > 0) {
                    $('#newTitle').val('');
                    $('#newHref').val('');
                    $('#newComment').val('');
                    getLinks();
                }
                else {
                    alert('Hay un error búscalo');
                }
            });
        }
        else {
            alert('No puedo procesarlo');
        }
    }

    $('#newsinglecategory #add-cat').on('click', evento_addcat);
    function evento_addcat(event) {
        event.preventDefault();
        var parametros;
        
        var nombre = $(this).prev().val().trim();
        if (nombre !== '') {
            parametros = {
                'nombre'  :   nombre
            }
            genericAjax('ajax/addcategory', parametros, 'post', function(json) {
                if (json.addcategory > 0) {
                    $(this).prev().val('');
                    getCategories();
                } 
            });
            
        } else {
            // Si el nombre está vacío
            alert('No puedes crear una categoria sin nombre')
        }
    }
    
    $('#cuerpoCategories .delete-cat').on('click', evento_deletecat);
    function evento_deletecat (event) {
        
        event.preventDefault();
        var parametros;
        
        var id = $(this).data('id');
         console.log('Vamos a borrar la cat id: ' + id);
        
        if (id > 0) {
            parametros = {
                'id'  :   id
            }
            genericAjax('ajax/deletecategory', parametros, 'post', function(json) {
                if (json.deletecategory > 0) {
                    getCategories();
                } 
            });
            
        } else {
            alert('Error enviando al servidor');
        }
    }
    
    $('#cuerpoLinks a.delete-link').on('click', evento_deletelink);
    function evento_deletelink (event) {
        
        event.preventDefault();
        var parametros;
        
        var id = $(this).data('id');
         console.log('Vamos a borrar el link id: ' + id);
        
        if (id > 0) {
            parametros = {
                'id'  :   id
            }
            genericAjax('ajax/deletelink', parametros, 'post', function(json) {
                if (json.deletelink > 0) {
                    getLinks();
                } else {
                    alert('Error borrando');
                }
                
            });
            
        } else {
            alert('Error enviando al servidor');
        }
    }
    
    $('#cuerpoCategories .single-cat').on('click', evento_singlecat);
    function evento_singlecat (e) {
        e.preventDefault();
    }
    
    $('ul.pagination a').on('click', evento_ulpagination);
    function evento_ulpagination (e) {
        
        e.preventDefault();
        
        var pagina = $(this).data('page');
        console.log('PAGINA: ' + pagina);
        
        getLinks(pagina);
        
    }
    
    var reasignaEventos = function() {
        
        console.log('Refrescando manejadores de eventos...');
        $('div.card-read #btRegister').off('click', evento_btRegister);
        $('#newsinglecategory #add-cat').off('click', evento_addcat);
        $('#cuerpoCategories .delete-cat').off('click', evento_deletecat);
        $('#cuerpoLinks .delete-link').off('click', evento_deletelink);
        $('#cuerpoCategories .single-cat').off('click', evento_singlecat);
        $('ul.pagination a').off('click', evento_ulpagination);
        
        $('div.card-read #btRegister').on('click', evento_btRegister);
        $('#newsinglecategory #add-cat').on('click', evento_addcat);
        $('#cuerpoCategories .delete-cat').on('click', evento_deletecat);
        $('#cuerpoLinks .delete-link').on('click', evento_deletelink);
        $('#cuerpoCategories .single-cat').on('click', evento_singlecat);
        $('ul.pagination a').on('click', evento_ulpagination);
    }
    
})();
