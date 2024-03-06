/**
 * .eslint.js
 *
 * ESLint configuration file.
 */

module.exports = {
  root: true,
  env: {
    node: true,
  },
  extends: [
    "plugin:vue/vue3-recommended",
    "eslint:recommended",
    "plugin:prettier-vue/recommended",
    "@vue/eslint-config-typescript",
  ],

  rules: {
    "vue/multi-word-component-names": "off",
    semi: [1, "always"],
    quotes: [1, "double"],
    "prettier-vue/prettier": [
      "error",
      {
        // Override all options of `prettier` here
        // @see https://prettier.io/docs/en/options.html
        trailingComma: "es5",
        indent: 2,
      },
    ],
  },
};
