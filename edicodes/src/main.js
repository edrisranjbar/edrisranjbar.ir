import './assets/css/fonts.css'
import './assets/css/tailwind.css'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import Particles from 'vue3-particles'

/* Import FontAwesome core */
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* Import specific icons */
import { faEnvelope, faHome, faHeart, faBook, faServer, faDatabase, faDiagramProject, faCode, faBolt, faShield, faPhone, faLocationDot, faPaperPlane, faCreditCard, faBars } from '@fortawesome/free-solid-svg-icons'
import { faGithub, faYoutube, faLinkedin } from '@fortawesome/free-brands-svg-icons'

/* Add icons to the library */
library.add(faEnvelope, faHome, faHeart, faBook, faServer, faDatabase, faDiagramProject, faCode, faBolt, faShield, faGithub, faYoutube, faLinkedin, faPhone, faLocationDot, faPaperPlane, faCreditCard, faBars)

const app = createApp(App)

/* Add FontAwesome component */
app.component('font-awesome-icon', FontAwesomeIcon)

app.use(router)
app.use(Particles)

app.mount('#app')
