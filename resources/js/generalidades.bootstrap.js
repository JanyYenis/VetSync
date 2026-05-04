import Generalidades from './generalidades.js';

// estos archivos EXTENDIEN la clase
import './generalidades/formularios.js';
import './generalidades/genericos.js';
import './generalidades/peticiones.js';
import './generalidades/mis-genericos.js';

// se crea UNA sola instancia
window.generalidades = new Generalidades();
