import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
import "leaflet/dist/leaflet.css";
import L from "leaflet";

window.L = L;

import { getColorFromIndicator } from "./utils/colorUtils";
window.getColorFromIndicator = getColorFromIndicator;
import "@fortawesome/fontawesome-free/css/all.css";
