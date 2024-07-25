
const create_notifications_panel_system = () => {
    let notifications_list = document.getElementById('notifications-content');
    let notifications_flag = document.getElementById('notifications-flag');
    let notifications_content_box = document.getElementById('notifications-box');
    let html = '';
    fetch(BASE_URL('notificaciones_nuevas_denuncias_administracion'), {
        method: 'POST'
    })
    .then(res => {
        if(!res.ok) {
            throw new Error('Ocurrió un error');
        }//end if
        return res.json();
    })
    .then(respuesta => {
        if(respuesta.data === -1) {
            notifications_flag.innerHTML = '';
            html = `
            <li>
                <div class="border-bottom rounded-top py-3 px-4">
                    <div class="mb-0 font-weight-medium fs-4">Sin notificaciones</div>
                </div>
            </li>
            `;
        }//end if no hay notificaciones
        else{
            if(respuesta.data.length == 0){
                notifications_flag.innerHTML = '';
                html = `
                <li>
                    <div class="border-bottom rounded-top py-3 px-4">
                        <div class="mb-0 font-weight-medium fs-4">Sin notificaciones</div>
                    </div>
                </li>
                `;
            }//end if no hay notificaciones
            else{
                notifications_flag.innerHTML = '<span class="heartbit"></span> <span class="point"></span>';
                html = `
                <li>
                    <div class="border-bottom rounded-top py-3 px-4">
                        <div class="mb-0 font-weight-medium fs-4">${respuesta.data.length == 1 ? 'Nueva notificación' : (respuesta.data.length <= 5 ? respuesta.data.length+' nuevas notificaciones' : 'Más de 5 nuevas notificaciones')}</div>
                    </div>
                </li>
                <li>
                    <div class="message-center notifications position-relative" id="notifications-box" style="height:${respuesta.data.length <= 5 ? (respuesta.data.length*78) : 380}px;">
                    `;
                    for(let i = 0; i < respuesta.data.length; i++) {
                        html += `
                        <a href="${respuesta.data[i].href}" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                            <span class="${respuesta.data[i].kind_circle}">
                                <i data-feather="${respuesta.data[i].icon}" class="feather-sm fill-white"></i>
                            </span>
                            <div class="w-75 d-inline-block v-middle ps-3">
                                <h5 class="message-title mb-0 mt-1 fs-3 fw-bold">${respuesta.data[i].title}</h5>
                                <span class="fs-2 text-nowrap d-block time text-truncate fw-normal text-muted mt-1">
                                    ${respuesta.data[i].text}
                                </span>
                                <span class="fs-2 text-nowrap d-block subtext text-muted">${respuesta.data[i].time}</span>
                            </div>
                        </a>
                        `;
                    }//end for respuesta.data
                html += `
                    </div>
                </li>
                `;
            }//end else hay notificaciones
        }//end else no hay notificaciones
        notifications_list.innerHTML = html;
        feather.replace();
    })
    .catch(error => {
        console.log("HUBO UN ERROR AL OBTENER TUS NOTIFICACIONES");
        notifications_flag.innerHTML = '';
        html = `
        <li>
            <div class="border-bottom rounded-top py-3 px-4">
                <div class="mb-0 font-weight-medium fs-4">Sin notificaciones</div>
            </div>
        </li>
        `;
        notifications_list.innerHTML = html;
        feather.replace();
    });
};//end crear_notificaciones_solicitudes


window.addEventListener('DOMContentLoaded', (event) => {
    create_notifications_panel_system();
    setInterval(function() {
        create_notifications_panel_system();
    }, 60000);
});
