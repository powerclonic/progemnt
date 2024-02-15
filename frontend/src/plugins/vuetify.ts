/**
 * plugins/vuetify.ts
 *
 * Framework documentation: https://vuetifyjs.com`
 */

// Styles
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'

// Composables
import { createVuetify } from 'vuetify'

const defaultTheme = {
    dark: true,
    colors: {
        background: "#151419",
        surface: "#151419",
        primary: "#F56E0F",
        secondary: "#878787",
        "secondary-darken-1": "#262626",
        "secondary-darken-2": "#1B1B1E",
        white: "#FBFBFB",
        warning: "#F5E10F",
        error: "#F50F23"
    }
}

// https://vuetifyjs.com/en/introduction/why-vuetify/#feature-guides
export default createVuetify({
    theme: {
        defaultTheme: "defaultTheme",
        themes: {
            defaultTheme
        },
    },
    
})
