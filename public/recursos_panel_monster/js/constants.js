let BASE_URL = function(route = ''){return location.protocol + '//' + location.host + (route == '' ? '' : '/'+route)};

//******************************************************************************
//********************************* CONSTANTES *********************************
//******************************************************************************

//SEXOS
let S_F = 45;
let S_M = 90;

//RUTAS BASE
let R_P_C = 'recursos_panel_monster/css';
let R_P_J = 'recursos_panel_monster/js';
let R_P_I = 'recursos_panel_monster/images';
let R_P_P = 'recursos_panel_monster/plugins';

//DIRECTORIOS
let I_D_O = 'recursos_panel_monster/images/profile-images';
let I_D_S = 'images/sistema';
let I_D_I_S = 'images/iconos';
let I_D_SE = 'images/sedes';
let I_D_I_SE = 'images/icon_dis';
let I_D_SEA = 'images/diseno';




//ALERTAS
let SUCCESS_ALERT = 1;
let DANGER_ALERT = 2;
let INFO_ALERT = 3;
let WARNING_ALERT = 4;

//ERRORRES
let S_E = 0;
let E_S = 1;

//ESTATUS
let E_H = 2;
let E_D = 2;

//TIPOS PERSONAS
let P_A = 24;//Abogado
let P_P = 70;//Parentesco
let P_U = 60;//Victima
let P_V = 36;//Visitante

//ESTATUS ACCESOS
let E_I_I = 125; 
let E_E_I = -125; 

