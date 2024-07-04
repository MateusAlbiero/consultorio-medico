
<section class="container-main">
    <section class="main">
        <header>
            <article>
                <h1>Pacientes</h1>
                <h5><a href="{{ route('pedidovenda.paciente') }}">Listagem de pacientes cadastrados</a> > Cadastro do paciente</h5>
            </article>
            @if ($editavel)
                <section class="white">
                    <button type="button" id="button-gravar" class="button buttonsObserver"  onclick="gravarpaciente();">Gravar</button>
                </section>
            @endif
        </header>
        <div class="container-box border-3px-blue animado fadeInBottom">
            <span class="font-20">Dados do paciente</span>
            <section class="flex flex-w mt-2 gap-1">
                <input type="hidden" name="controle" id="controle" @if(isset($paciente)) value="{{ $paciente->controle }}" @endif>
                <article class="form-group cl-3 min-w-200px">
                    <fieldset class="input">
                        <legend>CPF <strong class="red">*</strong></legend>
                        <input type="text" name="cnpjcpf" id="cnpjcpf"  class="cnpjcpf" inputmode="numeric" class="input-button" @if(isset($paciente)) value="{{ formata($paciente->cnpjcpf) }}" @endif autofocus @if(!$editavel) readonly @else onblur="validaCNPJCPF(this)" @endif>
                        <button class="icon" id="buscarempresa" type="button" tabindex="-1" onclick="buscarEmpresa();">
                            <svg width="18px" height="18px" viewBox="0 0 2117 2117">
                                <g id="Camada_x0020_1">
                                    <path class="fillButton" d="M1360 1499c-148,118 -330,181 -520,181 -463,0 -840,-377 -840,-840 0,-463 377,-840 840,-840 463,0 840,377 840,840 0,190 -63,372 -181,520l589 588c38,39 38,101 0,140 -19,18 -44,29 -70,29 -26,0 -51,-11 -70,-29l-588 -589zm-520 -16c355,0 643,-288 643,-643 0,-354 -288,-643 -643,-643 -354,0 -643,289 -643,643 0,355 289,643 643,643z"></path>
                                </g>
                            </svg>                                
                        </button>                                
                    </fieldset>
                    <small>Pressione enter para buscar</small>
                    <section class="erro">
                        <small></small>
                    </section>
                </article>
                <article class="form-group cl">
                        <fieldset class="input">
                            <legend>Cliente <strong class="red">*</strong></legend>
                            <input type="text" name="razaosocial" id="razaosocial" @if(isset($paciente)) value="{{ $paciente->razaosocial }}" @endif onblur="handleOnBlur(this)" @if(!$editavel) readonly @endif>
                        </fieldset>
                        <section class="erro">
                            <small></small>
                        </section>
                </article>
            </section>
            <section class="flex-w flex mb-1 gap-1">
                <article class="form-group cl-3">
                    <fieldset class="input">
                        <legend>Telefone</legend>
                        <input type="text" name="telefone" id="telefone" class="telefone" @if(isset($paciente)) value="{{ $paciente->telefone }}" @endif @if(!$editavel) readonly @endif oninput="formatarTelefoneCelular(this);" onblur="validaTelefone(this);">
                    </fieldset>
                    <section class="erro">
                        <small></small>
                    </section>
                </article>
                <article class="form-group cl-3">
                    <fieldset class="input">
                        <legend>Celular</legend>
                        <input type="text" name="celular" id="celular" class="celular" @if(isset($paciente)) value="{{ $paciente->celular }}" @endif @if(!$editavel) readonly @endif oninput="formatarTelefoneCelular(this);" onblur="validaCelular(this);">
                    </fieldset>
                    <section class="erro">
                        <small></small>
                    </section>
                </article>
                <article class="form-group cl">
                    <fieldset class="input">
                        <legend>E-mail</legend>
                        <input type="text" name="email" id="email" class="email" @if(isset($paciente)) value="{{ $paciente->email }}" @endif @if(!$editavel) readonly @endif data-type="email" onblur="validaEmail(this);">
                    </fieldset>
                    <section class="erro">
                        <small></small>
                    </section>
                </article>
            </section>
            <span class="font-20 b-4">Dados do endereço</span>
            <section class="flex flex-w mt-2 gap-1">
                <article class="form-group cl-3">
                    <fieldset class="input">
                        <legend>CEP <strong class="red">*</strong></legend>
                        <input type="text" inputmode="decimal" name="cep" id="cep" autofill="off" class="input-button cep" @if(isset($paciente)) value="{{ formata_cep($paciente->cep) }}" @endif @if(!$editavel) readonly @endif oninput="formatarCEP(this);" onblur="handleCEPBlur(this);">
                        <button class="icon" type="button" tabindex="-1" onclick="validarCEP();">
                            <svg width="18px" height="18px" viewBox="0 0 2117 2117">
                                <g id="Camada_x0020_1">
                                    <path class="fillButton" d="M1360 1499c-148,118 -330,181 -520,181 -463,0 -840,-377 -840,-840 0,-463 377,-840 840,-840 463,0 840,377 840,840 0,190 -63,372 -181,520l589 588c38,39 38,101 0,140 -19,18 -44,29 -70,29 -26,0 -51,-11 -70,-29l-588 -589zm-520 -16c355,0 643,-288 643,-643 0,-354 -288,-643 -643,-643 -354,0 -643,289 -643,643 0,355 289,643 643,643z"></path>
                                </g>
                            </svg>                                
                        </button>                              
                    </fieldset>
                    <small>Pressione enter para buscar</small>
                    <section class="erro">
                        <small></small>
                    </section>                           
                </article>
                <article class="form-group cl-2">
                    <fieldset class="select" aria-hidden="true">
                        <legend>UF <strong class="red">*</strong></legend>
                        <input type="text" name="ufhidden" id="ufhidden" hidden>
                        <input type="text" @if(isset($paciente)) value="{{ $paciente->uf }}" data-value="{{ substr($paciente->codigoibge, 0, 2) }}" @else value="{{ $uf[0]->uf }}" data-value="{{ $uf[0]->codigouf }}" @endif name="uf" id="uf" @if($editavel) class="preenchido pointer" @endif readonly @if ($paciente) disabled @endif>                                
                        @if($editavel)
                            <button type="button" class="icon" tabindex="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="18px" height="18px" viewBox="0 0 900 300">
                                    <path class="fillButton" d="M312 251l222 -236c10,-9 23,-15 37,-15l1 0c29,0 53,24 53,53 0,14 -6,27 -17,38l-258 274c-8,7 -17,12 -27,14 -4,1 -7,1 -11,1 -3,0 -7,0 -10,-1 -11,-2 -20,-7 -26,-13l-261 -276c-10,-10 -15,-23 -15,-37 0,-29 24,-53 53,-53l1 0c14,0 27,6 35,15l223 236z"></path>
                                </svg>
                            </button>
                            <section class="lista">
                                <ul>
                                    @foreach ($uf as $u)
                                        <li data-value="{{ $u->codigouf }}" data-content="{{ $u->uf }}" data-callback="buscarMunicipio();">{{ $u->uf }}</li>
                                    @endforeach
                                </ul>
                            </section>
                        @endif
                    </fieldset>
                    <section class="erro">
                        <small></small>
                    </section>
                </article>
                <article class="form-group cl">
                    <fieldset class="select" aria-hidden="true">
                        <legend>Município <strong class="red">*</strong></legend>
                        <input type="text" name="municipiohidden" id="municipiohidden" hidden>
                        <input type="text" value="{{ old('municipio') }}" @if(isset($paciente)) value="{{ $paciente->cidade }}" data-value="{{ $paciente->codigoibge }}" @endif name="municipio" id="municipio" @if($editavel) class="preenchido pointer" @endif readonly @if ($paciente) disabled @endif>
                        @if($editavel)
                            <button type="button" class="icon" tabindex="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="18px" height="18px" viewBox="0 0 900 300">
                                    <path class="fillButton" d="M312 251l222 -236c10,-9 23,-15 37,-15l1 0c29,0 53,24 53,53 0,14 -6,27 -17,38l-258 274c-8,7 -17,12 -27,14 -4,1 -7,1 -11,1 -3,0 -7,0 -10,-1 -11,-2 -20,-7 -26,-13l-261 -276c-10,-10 -15,-23 -15,-37 0,-29 24,-53 53,-53l1 0c14,0 27,6 35,15l223 236z"></path>
                                </svg>
                            </button>
                            <section class="lista">
                                <ul></ul>                            
                            </section>
                        @endif
                    </fieldset>
                    <section class="erro">
                        <small></small>
                    </section>                            
                </article>                   
            </section>
            <section class="flex-w gap-1">
                <article class="form-group cl">
                    <fieldset class="input">
                        <legend>Endereço<strong class="red"> *</strong></legend>
                        <input type="text" name="endereco" id="endereco" @if(isset($paciente)) value="{{ $paciente->endereco }}" @endif @if(!$editavel) readonly @endif onblur="validaEndereco(this);">
                    </fieldset>
                    <section class="erro">
                        <small></small>
                    </section>                            
                </article>
                <article class="form-group cl-2">
                    <fieldset class="input">
                        <legend>Nº</legend>
                        <input type="text" name="numero" id="numero" @if(isset($paciente)) value="{{ $paciente->numero }}" @endif maxlength="5" onkeydown="validarNumero(this, event)" @if(!$editavel) readonly @endif>
                    </fieldset>                           
                </article>
            </section>
            <section class="flex-w mb-2 gap-1">
                <article class="form-group cl">
                    <fieldset class="input">
                        <legend>Bairro <strong class="red">*</strong></legend>
                        <input type="text" name="bairro" id="bairro" @if(isset($paciente)) value="{{ $paciente->bairro }}" @endif @if(!$editavel) readonly @endif onblur="validaBairro(this);">
                    </fieldset>
                    <section class="erro">
                        <small></small>
                    </section> 
                </article>
                <article class="form-group cl">
                    <fieldset class="input">
                        <legend>Complemento</legend>
                        <input type="text" name="complemento" id="complemento" @if(isset($paciente)) value="{{ $paciente->complemento }}" @endif @if(!$editavel) readonly @endif>
                    </fieldset>
                </article>
            </section>
        </div>
        <section class="flex-je">
            <button type="button" class="button mb-3 buttonsObserverHidden" id="btnGravarDados" onclick="gravarpaciente();">Gravar</button>
        </section> 
    </section>
</section>
@component('components.btn-scrolltop')@endcomponent
@push('script')
    @if(isset($paciente))
        <script>
            var
                tablePedido = null,
                tablePedidoParams = {
                    dom: 'rti<"flex-jc mt-1"p>',
                    scrollX:        true,
                    scrollCollapse: true,
                    fixedColumns:   {
                        leftColumns: 0,
                        rightColumns: 1
                    },
                    searching: true,
                    serverSide: false,
                    processing: false,
                    autoWidth: false,
                    bAutoWidth: false,
                    info: false,
                    pagingType: 'simple_numbers',
                    order: [0, 'desc'],
                    tabIndex: -1,
                    language: {
                        url: "{{ asset('assets/lang/Portuguese-Brasil.json') }}"
                    },
                    ajax: {
                        "url" : "{{ route('pedidovenda.pedido.get', '_ID_') }}".replace('_ID_', '{{$paciente->controle}}'),
                        "data" : function(d) {
                            d.arrayfiltro = arrayfiltro; 
                            d.periodo = periodo; 
                        }
                    },
                    drawCallback: function( settings ) {
                        colspan();
                    },
                    columnDefs: [
                        {
                            targets: [0,2,3,4],
                            className: 'text-c pr-4'
                        },
                        {
                            targets: 0,
                            render: function(data) {
                                return ("000000" + data).slice(-6);
                            }
                        },
                        {
                            targets: 3,
                            render: function ( data, type, row, meta ) {
                                if(data == 'ABERTO'){
                                    return '<span data-tooltip="Pedido aberto" data-tooltip-location="left" class="status-dark-badge">' + data + '</span>';
                                }
                                if(data == 'FINALIZADO'){
                                    return '<span data-tooltip="Pedido finalizado" data-tooltip-location="left" class="status-success-badge">' + data + '</span>';
                                }
                                if(data == 'EMITIDO'){
                                    return '<span data-tooltip="Pedido emitido" data-tooltip-location="left" class="status-primary-badge">' + data + '</span>';
                                }
                                if(data == 'CANCELADO'){
                                    return '<span data-tooltip="Pedido cancelado" data-tooltip-location="left" class="status-danger-badge">' + data + '</span>';
                                }
                                return data;
                            }
                        },
                    ],       
                    columns: [
                        {data: 'controle', name: 'controle', className: 'text-c nowrap' },
                        {data: 'paciente', name: 'paciente', className: 'nowrap' },
                        {data: 'datahoracadastro', name: 'datahoracadastro', className: 'text-c nowrap' },
                        {data: 'status', name: 'status', className: 'text-c nowrap' },
                        {data: 'acoes', name: 'acoes', orderable: false, searchable: false, className: 'text-c nowrap'},
                    ],
                    createdRow: function(row, data, dataIndex) {
                        if (data['status'] == 'FINALIZADO') {
                            $(row).addClass('text-status-success');
                        }
                        if (data['status'] == 'CANCELADO') {
                            $(row).addClass('text-status-danger');
                        }
                        if (data['status'] == 'EMITIDO') {
                            $(row).addClass('text-status-primary');
                        }
                    }
                },
                pesquisaPedido = null,
                arrayfiltro = ['1', '2', '3', '4'],
                periodo = new Object();

            function filtrar() {
                arrayfiltro = [];
                document.querySelectorAll('.filtrosituacao button').forEach(element => {
                    if (element.dataset.marcado == 1)
                        arrayfiltro.push(element.dataset.id);
                });

                if (arrayfiltro.length == 0) {
                    arrayfiltro = ['1', '2', '3', '4'];
                }

                periodo.datai = document.getElementById('datainicio').disabled ? 0 : moment(document.getElementById('datainicio').value, 'DD/MM/YYYY').format('YYYY-MM-DD');
                periodo.dataf = document.getElementById('datatermino').disabled ? 0 : moment(document.getElementById('datatermino').value, 'DD/MM/YYYY').format('YYYY-MM-DD');
                
                tablePedido.ajax.reload();
            }

            function buscar() {
                tablePedido.search(pesquisaPedido.value).draw();
            }

            window.addEventListener('load', function() {
                tablePedido = $('#tablePedido').DataTable(tablePedidoParams);
                pesquisaPedido = document.getElementById('pesquisapedido');
                periodo.datai = 0;
                periodo.dataf = 0;

                pesquisaPedido.focus();

                setTimeout(() => {
                    if (pesquisaPedido.value.length > 0) {
                        buscar();
                    }
                }, 100)

                tablePedido.on('draw', function() {
                    var
                        aberto      = 0,
                        finalizado  = 0,
                        emitido     = 0,
                        cancelado   = 0;

                    tablePedido.rows().every(function() {
                        const
                            element = this.data();
                        
                        switch (element.status) {
                            case 'ABERTO':
                                aberto++;
                                break;
                            case 'FINALIZADO':
                                finalizado++;
                                break;
                            case 'EMITIDO':
                                emitido++;
                                break;
                            case 'CANCELADO':
                                cancelado++;
                                break;
                        }
                    })

                    document.querySelector('button[data-id="1"]').dataset.content = aberto;
                    document.querySelector('button[data-id="2"]').dataset.content = finalizado;
                    document.querySelector('button[data-id="3"]').dataset.content = emitido;
                    document.querySelector('button[data-id="4"]').dataset.content = cancelado;
                })   
                
                $('.filtrodata button.icon').datepicker({
                    language: "pt-BR",
                    keyboardNavigation: false,
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true,  
                    orientation: "bottom auto",          
                    }).on('changeDate', function(e) {
                        $(this).prev().val(e.format());
                        filtrar();
                });                       
            })  
            
            window.addEventListener('keydown', function(event) {
                if (event.which == 13) {
                    if (document.activeElement == pesquisaPedido)
                        buscar();
                }
            })                
                
        </script>
    @endif
    <script>
        const
            id = "{{ isset($paciente) ? $paciente->controle : null }}";

        function validarCampo(obj){
            obj.parentElement.classList.remove('invalido');
            obj.closest('.form-group').querySelector('.erro small').textContent = "";
        }

        function limparDadospaciente(){
            razaosocial.value   = '';
            nomefantasia.value  = '';
            ie.value            = '';
            cep.value           = '';
            telefone.value      = '';
            celular.value       = '';
            email.value         = '';
            numero.value        = '';
            endereco.value      = '';
            bairro.value        = '';
            complemento.value   = '';
        }

        function validarNumero(objeto, event) {
            const
                teclasPermitidas = [
                    8, 9, 13, 46
                ],
                teclasPermitidasNumerico = [
                    48, 49, 50, 51, 52, 53, 
                    54, 55, 56, 57, 96, 
                    97, 98, 99, 100, 101, 
                    102, 103, 104, 105
                ],
                teclasPermitidasAlfanumerico = [
                    83
                ];

            if (teclasPermitidas.indexOf(event.which) === -1 && teclasPermitidasNumerico.indexOf(event.which) === -1 && teclasPermitidasAlfanumerico.indexOf(event.which) === -1) {
                event.preventDefault();
                return false;
            }

            if (objeto.value.trim().length > 0) {
                if (objeto.value.toUpperCase() == 'S/N' && teclasPermitidas.indexOf(event.which) == -1) {
                    event.preventDefault();
                    return false;
                }

                if (teclasPermitidasAlfanumerico.indexOf(event.which) > -1 && /[0-9]/g.test(objeto.value)) {
                    event.preventDefault();
                    return false;
                }
                if (teclasPermitidasNumerico.indexOf(event.which) > -1 && /[^0-9]/g.test(objeto.value)) {
                    event.preventDefault();
                    return false;
                }
            }

            if (teclasPermitidasAlfanumerico.indexOf(event.which) > -1) {
                objeto.value = 'S/N';
                event.preventDefault();
                return false;
            }
        }   

        function handleCEPBlur(obj) {
            validaCEPObrigatorio(obj);
            if ($.trim(obj.value).replace(/[^0-9]/g, '').length === 8) {
                validarCEP();
            }
        }

        function validaCEPObrigatorio(obj) {
            var cepValue = $.trim(obj.value).replace(/[^0-9]/g, '');
            var erroSection = obj.closest('.cl-3').querySelector('.erro small');
            
            if (cepValue.length === 0) {
                obj.parentElement.classList.add('invalido');
                erroSection.textContent = "* CEP é obrigatório";
            } else if (cepValue.length !== 8) {
                obj.parentElement.classList.add('invalido');
                erroSection.textContent = "* CEP inválido";
            } else {
                obj.parentElement.classList.remove('invalido');
                erroSection.textContent = "";
            }
        }


        function validarCEP(callback = null) {
            var 
                cep                 = document.getElementById('cep').value.replace(/[^0-9]/g, ''),
                uf                  = document.getElementById('uf'),
                ufBuscado           = null;
                municipio           = document.getElementById('municipio'),
                municipioBuscado    = null;
                endereco            = document.getElementById('endereco'),
                bairro              = document.getElementById('bairro'),
                complemento         = document.getElementById('complemento');

            if (cep && /^[0-9]{8}$/.test(cep)) {
                endereco.value      = '';
                bairro.value        = '';
                complemento.value   = '';

                $.getJSON('https://viacep.com.br/ws/' + cep + '/json/?callback=?', function(response) {
                    if (!('erro' in response)) {
                        ufBuscado           = uf.parentElement.querySelector('.lista ul li[data-content*="' + response.uf  + '"]')
                        uf.value            = ufBuscado.dataset.content;
                        uf.dataset.value    = ufBuscado.dataset.value;
                        endereco.value      = response.logradouro;
                        bairro.value        = response.bairro;
                        complemento.value   = response.complemento;

                        validarCampo(document.getElementById('cep'));
                        validarCampo(endereco);
                        validarCampo(bairro);

                        buscarMunicipio(function() {
                            municipioBuscado        = municipio.parentElement.querySelector('.lista ul li[data-content*="' + retira_acentos(response.localidade.toUpperCase()) + '"]');
                            municipio.value         = municipioBuscado.dataset.content;
                            municipio.dataset.value = municipioBuscado.dataset.value;
                        });
                    } else {
                        endereco.value      = '';
                        bairro.value        = '';
                        complemento.value   = '';
                    }
                });

                if (callback) callback();
            }
        }

        function retira_acentos(palavra) { 
            com_acento = 'üÜ'; 
            sem_acento = 'uU'; 
            nova = ''; 
            for(i=0; i<palavra.length; i++) { 
                if (com_acento.search(palavra.substr(i,1))>=0) { 
                    nova += sem_acento.substr(com_acento.search(palavra.substr(i,1)),1); 
                } 
                else { 
                    nova+=palavra.substr(i,1); 
                } 
            } 
            return nova; 
        }

        function buscarMunicipio(callback = null) {
            var
                uf              = document.getElementById('uf'),
                municipio       = document.getElementById('municipio'),
                municipioLista  = municipio.parentElement.querySelector('.lista ul');

            $.ajax({
                url: ("{{ route('cadastro.verificauf', '_id_') }}").replace('_id_', uf.dataset.value),
                type: "GET", 
                datatype: "JSON",
            }).done(function(response) {
                if (response) {
                    if (municipioLista) {
                        municipioLista.innerHTML = '';
                        response.forEach(function(element, index, array){
                            var
                                municipioItem = document.createElement('li');
    
                            municipioItem.setAttribute("data-value", element.codigoibge);
                            municipioItem.setAttribute("data-content", element.nome);
                            municipioItem.innerHTML = element.nome;
    
                            municipioLista.appendChild(municipioItem);
    
                            if (index == 0 && !callback) {
                                municipio.setAttribute("data-value", element.codigoibge);
                                municipio.value = element.nome;
                            }
                        })
                    } else {
                        municipio.setAttribute("data-value", response[0].codigoibge);
                        municipio.value = response[0].nome;                        
                    }

                    if (callback) callback();
                }
            });
        }

        var 
            cnpjcpf = null;
        
        window.addEventListener('load', function() {
            cep     = document.getElementById('cep');
            cnpjcpf = document.getElementById('cnpjcpf');

            cep.addEventListener('input', function() {
                formatarCEP(this);
            })
            cnpjcpf.addEventListener('input', function() {
                formataCNPJCPF(this);
            })
                
            if (id) {
                buscarMunicipio(function() {
                    @if(isset($paciente))
                    
                        var 
                            municipio = document.getElementById('municipio');

                        municipio.value         = "{{ $paciente->cidade }}";
                    @endif
                });
            } else {
                
                buscarMunicipio();
            }

            formatarCEP(cep);
            formataCNPJCPF(cnpjcpf);
        })

        window.addEventListener('keydown', function(event) {
                if (event.which == 13) {
                    if (document.activeElement == cnpjcpf)
                        buscarEmpresa();
                    if (document.activeElement == cep)
                        validarCEP();
                }
            })      

        function gravarpaciente(){
            url = "{{ route('gravar') }}";

            data = {
                controle:       $.trim(document.getElementById('controle').value),
                cnpjcpf:        $.trim(document.getElementById('cnpjcpf').value),
                ie:             $.trim(document.getElementById('ie').value),
                razaosocial:    $.trim(document.getElementById('razaosocial').value),
                nomefantasia:   $.trim(document.getElementById('nomefantasia').value),
                telefone:       $.trim(document.getElementById('telefone').value),
                celular:        $.trim(document.getElementById('celular').value),
                email:          $.trim(document.getElementById('email').value),
                cep:            $.trim(document.getElementById('cep').value),
                uf:             $.trim(document.getElementById('uf').value),
                municipio:      $.trim(document.getElementById('municipio').value),
                codcidadeibge:  $.trim(document.getElementById('municipio').dataset.value),
                endereco:       $.trim(document.getElementById('endereco').value),
                numero:         $.trim(document.getElementById('numero').value),
                bairro:         $.trim(document.getElementById('bairro').value),
                complemento:    $.trim(document.getElementById('complemento').value),
            };

            gravar(url, data, 'POST').then((data) => {
                if (data.gravou) {
                window.location = "{{route('pedidovenda.paciente')}}"
                }
            });
        }

        function validaCNPJCPF(obj) {
            const value = $.trim(obj.value);
            const erroSection = obj.closest('.form-group').querySelector('.erro small');
            if (value.length === 0) {
                obj.parentElement.classList.add('invalido');
                erroSection.textContent = "* CNPJ/CPF é obrigatório";
            } else if (!validarCNPJCPF(value)) {
                obj.parentElement.classList.add('invalido');
                erroSection.textContent = "* CNPJ/CPF inválido";
            } else {
                obj.parentElement.classList.remove('invalido');
                erroSection.textContent = "";
            }
        }

        function validaFantasia(obj) {
            const value = $.trim(obj.value);
            const erroSection = obj.closest('.form-group').querySelector('.erro small');

            if (value.length === 0) {
                obj.parentElement.classList.add('invalido');
                erroSection.textContent = "* Fantasia é obrigatória";
            } else {
                obj.parentElement.classList.remove('invalido');
                erroSection.textContent = "";
            }
        }

        function validaEmail(obj){
            const email = $.trim(obj.value);
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (email.length > 0 && !emailPattern.test(email)) {
                obj.parentElement.classList.add('invalido');
                obj.closest('.cl').querySelector('.erro small').textContent = "* E-mail inválido";
            } else {
                obj.parentElement.classList.remove('invalido');
                obj.closest('.cl').querySelector('.erro small').textContent = "";
            }
        }

        function validaCelular(obj){
            const value = obj.value.replace(/[^0-9]/g, '');
            const valueLength = value.length;

            if (valueLength > 0 && valueLength !== 11) {
                obj.parentElement.classList.add('invalido');
                obj.closest('.cl-3').querySelector('.erro small').textContent = "* Celular inválido";
            } else {
                obj.parentElement.classList.remove('invalido');
                obj.closest('.cl-3').querySelector('.erro small').textContent = "";
            }
        }

        function validaTelefone(obj){
            const value = obj.value.replace(/[^0-9]/g, '');
            const valueLength = value.length;

            if (valueLength > 0 && valueLength !== 10) {
                obj.parentElement.classList.add('invalido');
                obj.closest('.cl-3').querySelector('.erro small').textContent = "* Telefone inválido";
            } else {
                obj.parentElement.classList.remove('invalido');
                obj.closest('.cl-3').querySelector('.erro small').textContent = "";
            }
        }

        function validaEndereco(obj) {
            var enderecoValue = $.trim(obj.value);
            var erroSection = obj.closest('.cl').querySelector('.erro small');
            
            if (enderecoValue.length === 0) {
                obj.parentElement.classList.add('invalido');
                erroSection.textContent = "* Endereço é obrigatório";
            } else if (enderecoValue.length <= 1) {
                obj.parentElement.classList.add('invalido');
                erroSection.textContent = "* Endereço deve conter mais que 1 caractere";
            } else {
                obj.parentElement.classList.remove('invalido');
                erroSection.textContent = "";
            }
        }

        function validaBairro(obj) {
            var bairroValue = $.trim(obj.value);
            var erroSection = obj.closest('.cl').querySelector('.erro small');

            if (bairroValue.length === 0) {
                obj.parentElement.classList.add('invalido');
                erroSection.textContent = "* Bairro é obrigatório";
            } else if (bairroValue.length <= 1) {
                obj.parentElement.classList.add('invalido');
                erroSection.textContent = "* Bairro deve conter mais que 1 caractere";
            } else {
                obj.parentElement.classList.remove('invalido');
                erroSection.textContent = "";
            }
        }

        closeOptionsButton = function(obj) {
            var tabela = document.querySelectorAll('table tbody tr td button section');
            for (let index = 0; index < tabela.length; index++) {
                const element = tabela[index];
                if (obj) {
                    if (obj != element.parentElement) {
                        element.classList.remove('ativo')
                    }
                } else
                    element.classList.remove('ativo')
            }
        }

        optionsButton = function(obj) {
            closeOptionsButton(obj);
            if (obj.querySelector('section').classList.contains('ativo')) {
                obj.querySelector('section').classList.remove('ativo');
            } else {
                obj.querySelector('section').classList.add('ativo');
            }
        }            
    </script>
@endpush