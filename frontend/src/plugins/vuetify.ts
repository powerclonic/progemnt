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
import { VSheet, VBtn } from "vuetify/lib/components/index.mjs";

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

    info: "#0f96f5",
    sucess: "#007700",
    warning: "#dd9900",
    error: "#ff6c6c",
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
    VBtnChip: VBtn,

    VSheetLighter: VSheet,
  },
  defaults: {
    VDialog: {
      VTextField: {
        variant: "solo-filled",
        density: "comfortable",
        bgColor: "secondary-darken-1",
      },
      VSelect: {
        variant: "solo-filled",
        density: "comfortable",
        bgColor: "secondary-darken-1",
      },
    },

    VToolbar: {
      VBtn: {
        variant: "flat",
      },
    },
    VCardActions: {
      VBtn: {
        variant: "flat",
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
    VBtnChip: {
      variant: "flat",
      color: "secondary-darken-1",
      class: "text-white font-weight-regular ",
      rounded: "pill",
    },

    VSheet: {
      rounded: true,
      color: "secondary-darken-2",
      class: "pa-2",
    },
    VSheetLighter: {
      rounded: true,
      color: "secondary-darken-1",
      class: "pa-2",
    },
  },
});
