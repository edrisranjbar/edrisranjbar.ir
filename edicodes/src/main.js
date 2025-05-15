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
import { faEnvelope, faHome, faHeart, faBook, faServer, faDatabase, faDiagramProject, faCode, faBolt, faShield, faPhone, faLocationDot, faPaperPlane, faCreditCard, faBars, faXmark as faTimes, faExclamationCircle, faCircleNotch, faCheckCircle, faInfoCircle, faGlobe, faArrowLeft, faRocket, faSearch, faCalendar, faChevronDown, faTachometerAlt, faNewspaper, faPlusCircle, faFolder, faPlus, faEdit, faTrashAlt, faEye, faMagic, faSave, faLock, faSignOutAlt, faFolderPlus, faRss, faDonate, faCog,
// Block editor icons
faBold, faItalic, faUnderline, faHeading, faParagraph, faListUl, faListOl, faAlignLeft, faAlignCenter, faAlignRight, faAlignJustify, faQuoteRight, faMinus, faImage, faLink, faUnlink, faUndo, faRedo,
// Block menu icons
faVideo, faMusic, faTable,
// File uploader icon
faCloudUploadAlt,
// Comment icons
faUser, faComments, faCommentSlash, faReply, faClock } from '@fortawesome/free-solid-svg-icons'
import { faGithub, faYoutube, faLinkedin, faTwitter, faTelegram } from '@fortawesome/free-brands-svg-icons'

/* Add icons to the library */
library.add(
  faEnvelope, faHome, faHeart, faBook, faServer, faDatabase, faDiagramProject, 
  faCode, faBolt, faShield, faGithub, faYoutube, faLinkedin, faPhone, 
  faLocationDot, faPaperPlane, faCreditCard, faBars, faTimes, faExclamationCircle, 
  faCircleNotch, faCheckCircle, faInfoCircle, faGlobe, faArrowLeft, faRocket, faSearch, 
  faCalendar, faTwitter, faTelegram, faChevronDown,
  // Admin icons
  faTachometerAlt, faNewspaper, faPlusCircle, faFolder, faPlus, faEdit, 
  faTrashAlt, faEye, faMagic, faSave, faLock, faSignOutAlt, faFolderPlus, faRss,
  // Block editor icons
  faBold, faItalic, faUnderline, faHeading, faParagraph, faListUl, faListOl, faAlignLeft, faAlignCenter, faAlignRight, faAlignJustify, faQuoteRight, faMinus, faImage, faLink, faUnlink, faUndo, faRedo,
  // Block menu icons
  faVideo, faMusic, faTable,
  // File uploader icon
  faCloudUploadAlt,
  // Comment icons
  faUser, faComments, faCommentSlash, faReply, faClock,
  // New icons
  faDonate,
  // New icon
  faCog
)

const app = createApp(App)

/* Add FontAwesome component */
app.component('font-awesome-icon', FontAwesomeIcon)

app.use(router)
app.use(Particles)

app.mount('#app')
