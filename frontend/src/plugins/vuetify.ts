/**
 * plugins/vuetify.ts
 *
 * Framework documentation: https://vuetifyjs.com`
 */

// Styles
import "@mdi/font/css/materialdesignicons.css";
import "vuetify/styles";

// Composables
import { createVuetify } from "vuetify";
import { VBtn } from "vuetify/components/VBtn";

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
    warning: "#FFBB22",
    error: "#FF6060",
  },
};

// https://vuetifyjs.com/en/introduction/why-vuetify/#feature-guides
export default createVuetify({
  theme: {
    defaultTheme: "defaultTheme",
    themes: {
      defaultTheme,
    },
  },
  aliases: {
    VBtnDark: VBtn,
    VBtnDarker: VBtn,
  },
  defaults: {
    VDialog: {
      VTextField: {
        variant: "solo-filled",
        density: "comfortable",
        bgColor: "secondary-darken-1",
        rounded: "lg",
      },
      VSelect: {
        variant: "solo-filled",
        density: "comfortable",
        bgColor: "secondary-darken-1",
        rounded: "lg",
      },
    },
    VToolbar: {
      VBtn: {
        variant: "flat",
        color: "primary",
        class: "text-secondary-darken-1",
      },
    },
    VBtn: {
      variant: "flat",
      color: "primary",
      class: "text-secondary-darken-1",
    },
    VBtnDark: {
      variant: "flat",
      color: "secondary-darken-1",
      class: "text-primary",
    },
    VBtnDarker: {
      variant: "flat",
      color: "secondary-darken-2",
      class: "text-primary",
    },
  },
});
