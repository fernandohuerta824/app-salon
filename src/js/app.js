const app = () => {
    const cita = JSON.parse(localStorage.getItem('cita')) ?? {
        nombre: document.querySelector('input#nombre').value,
        fecha: '',
        hora: '',
        servicios: []
    }
    const fechaInput = document.querySelector('input#fecha');
    const horaInput  = document.querySelector('input#hora');

    const paginacion = () => {
        const tabs = document.querySelector('.tabs');
        const paginacion = document.querySelector('.paginacion');
        const paginaInicial = 1;
        const paginaFinal = 3;
    
        let paso = 1;
        
        const cambiarVentana = () => {
            const seccionAnterior = document.querySelector('.seccion.mostrar');
            
            seccionAnterior.classList.remove('mostrar');
            seccionAnterior.classList.add('ocultar');
    
            const seccion = document.querySelector('#paso-' + paso);
    
            seccion.classList.remove('ocultar');
            seccion.classList.add('mostrar');
        }
    
        const cambiarEstiloBoton = () => {
            const buttonAnterior = tabs.querySelector('button.actual');
    
            buttonAnterior.classList.remove('actual');
    
            const button = document.querySelector(`button[data-paso="${paso}"]`);
    
            button.classList.add('actual');
        }
    
        const mostrarPaginacion = () => {
            const buttonSiguiente = document.querySelector('#siguiente');
            const buttonAnterior = document.querySelector('#anterior');
    
            if(paso === 1) {
                buttonAnterior.classList.add('ocultar');
                buttonSiguiente.classList.remove('ocultar');
            }
    
            if(paso === 2) {
                buttonAnterior.classList.remove('ocultar');
                buttonSiguiente.classList.remove('ocultar');
            }
    
            if(paso === 3) {
                buttonAnterior.classList.remove('ocultar');
                buttonSiguiente.classList.add('ocultar');
            }
        }

        const mensajeResumen = (data, resumenDatos, tipo) => {
            const p = document.createElement('P');
            p.classList.add('mensaje', tipo);
            p.textContent = data.data[tipo];
            const mensajeAnterior = document.querySelector(`p.mensaje.${tipo}`);

            if(mensajeAnterior)
                    mensajeAnterior.remove();
            resumenDatos.insertAdjacentElement('beforeend', p);
            setTimeout(() => p.remove(), 5000);
        }

        const reservarCita = async () => {
            const resumenDatos = document.querySelector('.resumen-datos');
            try {
                const JSONdata = JSON.stringify(cita);
            
                const result = await fetch('/api/citas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSONdata
                })
                const data = await result.json();
                
                if(result.status !== 201) 
                    return mensajeResumen(data, resumenDatos, 'error');

                const servicios = document.querySelectorAll('.servicio');
                servicios.forEach(s => {
                    s.classList.remove('seleccionado')
                })

                fechaInput.value = '';
                horaInput.value = '';

                resumenDatos.innerHTML = '';
                mensajeResumen(data, resumenDatos, 'exito');
                cita.fecha = '';
                cita.hora = '';
                cita.servicios = [];
                localStorage.setItem('cita', JSON.stringify(cita));
            } catch (error) {
                mensajeResumen({data: {error: 'Algo salio mal, intentelo despues'}}, resumenDatos, 'error');
            }
        }

        const mostrarResumen = () => {
            const resumen = document.querySelector('.resumen-datos');
            let mensaje = '';
            if(cita.servicios.length < 1)
                mensaje = 'Selecciona los servicios';
            else if(!cita.fecha) 
                mensaje = 'Selecciona la fecha y hora';
            else if(!cita.hora)
                mensaje = 'Selecciona la hora';
            
            const descripcionParrafo = document.querySelector('#paso-3 p');
            resumen.innerHTML = '';
            if(mensaje) {
                return descripcionParrafo.textContent = mensaje + ' antes de continuar';  
            }
                
            
            descripcionParrafo.textContent = 'Verifica que la informacion sea correcta';

            const { nombre, fecha, hora, servicios } = cita;

            const nombreP = document.createElement('P');
            nombreP.innerHTML = `<span>Nombre: </span> ${nombre}`;
            
            const fechaObj = new Date(fecha);
            const mes = fechaObj.getMonth();
            const dia = fechaObj.getDate();
            const year = fechaObj.getFullYear();

            const fechaP = document.createElement('P');
            fechaP.innerHTML = `<span>Fecha: </span> ${Intl.DateTimeFormat('es-mx', {dateStyle: 'full'}).format(new Date(Date.UTC(year, mes, dia) + ((1000 * 60 * 60 * 24) * 2)))}`;
           
            const horaP = document.createElement('P');
            horaP.innerHTML = `<span>Hora: </span> ${hora}`;
            
            resumen.append(nombreP, fechaP, horaP);

            servicios.forEach(s => {
                const { id, precio, nombre } = s;
                const contenedor = document.createElement('DIV');
                contenedor.classList.add('contenedor-servicio');

                const textoServicio = document.createElement('P');
                textoServicio.textContent = nombre;

                const precioServicio = document.createElement('P');
                precioServicio.innerHTML = `<span>Precio: </span> $${precio}`

                contenedor.append(textoServicio, precioServicio);

                resumen.appendChild(contenedor);
            })

            const botonReservar = document.createElement('BUTTON');

            botonReservar.classList.add('boton');
            botonReservar.textContent = 'Reservar Cita';
            botonReservar.addEventListener('click', reservarCita);
            resumen.appendChild(botonReservar);
        }

        const cambiarSeccion = pasoTab => {
            if(pasoTab < paginaInicial) paso = paginaInicial;
            else if(pasoTab > paginaFinal) paso = paginaFinal;
            else paso = pasoTab;
            cambiarVentana();
            cambiarEstiloBoton(); 
            mostrarPaginacion();
            if(paso === 3)
                mostrarResumen();
        }
        
        tabs.addEventListener('click', e => {
            const pasoTab = +e.target.getAttribute('data-paso');
    
            if(!pasoTab) return;
            cambiarSeccion(pasoTab);
        })
    
        paginacion.addEventListener('click', e => {
            const button = e.target;
    
            if(!button.classList.contains('boton')) return;
    
            const action = button.id;
            if(action === 'siguiente') cambiarSeccion(paso + 1);
            if(action === 'anterior') cambiarSeccion(paso - 1);
        })
    }
    
    const servicios = () => {
        /**
         * 
         * @param {{id, nombre, precio}} servicio 
         */
        const seleccionarServicio = servicio => {
            const servicioDiv = document.querySelector(`.servicio[data-id-servicio="${servicio.id}"]`)
            servicioDiv.classList.toggle('seleccionado');

            const { servicios } = cita;
            if(cita.servicios.some(s => s.id === servicio.id)) 
                cita.servicios = servicios.filter(s => s.id !== servicio.id);
            else
                cita.servicios = [...servicios, servicio];
            
            localStorage.setItem('cita', JSON.stringify(cita));
        }
    
        /**
        * 
        * @param {Array<servicio>} servicios 
        */
        const motrarServicios = servicios => {
            servicios.forEach(servicio => {
                const { id, nombre, precio } = servicio;
                
                const nombreServicio = document.createElement('P');
                nombreServicio.classList.add('nombre-servicio');
                nombreServicio.textContent = nombre;
                
                const precioServicio = document.createElement('P');
                precioServicio.classList.add('precio-servicio');
                precioServicio.textContent = `$${precio}`;
    
                const servicioDiv = document.createElement('DIV');
                servicioDiv.classList.add('servicio');
                servicioDiv.dataset.idServicio = id;
    
                servicioDiv.appendChild(nombreServicio);
                servicioDiv.appendChild(precioServicio);
                servicioDiv.addEventListener('click', e => seleccionarServicio({id, nombre, precio}))

                if(cita.servicios.some(s => s.id === id))
                    servicioDiv.classList.add('seleccionado')

                const contenedorServicios = document.querySelector('#servicios');
                
                contenedorServicios.appendChild(servicioDiv);
            })
        }
    
        const consultarServicios = async () => {
            try {
                const url = '/api/servicios';
                console.log(url);
                const result = await fetch(url);
                console.log(result);
                if(result.status !== 200) {
                    return;
                }
                
                const servicios = await result.json();
    
                motrarServicios(servicios);
            } catch(error) {
                console.log(error);
            }
        }
    
        consultarServicios();
    }

    const informacionCita = () => {
        

        fechaInput.value = cita.fecha;
        horaInput.value = cita.hora;

        /**
         * 
         * @param {Element|null} campo 
         * @param {HTMLElement} p 
         * @param {boolean} existeMensaje
         * @param {string} mensajeError
         * 
         * 
         */
        const mensajeErrorHora = (campo, p, existeMensaje, mensajeError) => {
            p.textContent = mensajeError;
            if(!existeMensaje) {
                campo.insertAdjacentElement('beforebegin', p);
                setTimeout(() => p.remove(), 5000)
            }
        }

        fechaInput .addEventListener('change', e => {
            let fecha = fechaInput.value;
            const dia = new Date(fecha).getUTCDay();
            const campoFecha = fechaInput.closest('.campo');
            const mensajeError = campoFecha.previousElementSibling;
            const existeMensaje = mensajeError.classList.contains('error');
            const hora = +horaInput.value.split(':')[0];
            if(dia === 0) {
                const p = document.createElement('P');
                p.classList.add('alerta', 'error');
                p.textContent = 'El dia domingo no trabajamos, eliga otro dia';
                if(!existeMensaje) {
                    campoFecha.insertAdjacentElement('beforebegin', p);
                    setTimeout(() => p.remove(), 5000)
                }
                
                fecha = fechaInput.value = horaInput.value = cita.hora = '';
            } else if(dia === 6 && hora && (hora < 10 || hora > 15)){
                const campo = horaInput.closest('.campo');
                const mensajeError = campo.previousElementSibling;
                const existeMensaje = mensajeError.classList.contains('error');
                const p = document.createElement('P');
                p.classList.add('alerta', 'error');
                mensajeErrorHora(campo, p, existeMensaje, 'Horario no valido los sabados, horario sabados: 10:00 - 15:00');
                horaInput.value = cita.hora = ''
            }  else
                if(existeMensaje) 
                    mensajeError.remove();    
        
            cita.fecha = fecha;
            localStorage.setItem('cita', JSON.stringify(cita))
        })

        horaInput .addEventListener('change', e => {
            const fecha = fechaInput.value;
            const dia = new Date(fecha).getUTCDay();
            let horaValue = horaInput.value;
            const hora = +horaInput.value.split(':')[0];

            const campo = horaInput.closest('.campo');
            const mensajeError = campo.previousElementSibling;
            const existeMensaje = mensajeError.classList.contains('error');
            const p = document.createElement('P');
            p.classList.add('alerta', 'error');
            
            if(!Number.isFinite(dia)) {
                mensajeErrorHora(campo, p, existeMensaje, 'Seleccione primero una fecha');
                horaInput.value = horaValue = '';
            } else if(dia === 6 && (hora < 10 || hora > 15)) {
                mensajeErrorHora(campo, p, existeMensaje, 'Horario no valido los sabados, horario sabados: 10:00 - 15:00');
                horaInput.value = horaValue = '';
            } else if(hora < 8 || hora > 19) {
                mensajeErrorHora(campo, p, existeMensaje, 'Horario no valido entre semana, horario entre semana: 08:00 - 19:00');
                horaInput.value = horaValue = '';
            } else {
                if(existeMensaje) 
                    mensajeError.remove();    
            }
                
            cita.hora = horaValue;
            localStorage.setItem('cita', JSON.stringify(cita))
        })
    }

    paginacion();
    servicios();
    informacionCita();
}

document.addEventListener('DOMContentLoaded', e => {
    app();
})