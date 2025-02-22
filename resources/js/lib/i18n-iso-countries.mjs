var __getOwnPropNames = Object.getOwnPropertyNames;
var __commonJS = (cb, mod) => function __require() {
  return mod || (0, cb[__getOwnPropNames(cb)[0]])((mod = { exports: {} }).exports, mod), mod.exports;
};
var require_i18n_iso_countries = __commonJS({
  "node_modules/i18n-iso-countries/index.js"(exports) {
    const codes = require("./codes.json");
    const supportedLocales = require("./supportedLocales.json");
    const removeDiacritics = require("diacritics").remove;
    const registeredLocales = {};
    const alpha2 = {}, alpha3 = {}, numeric = {}, invertedNumeric = {};
    codes.forEach(function(codeInformation) {
      const s = codeInformation;
      alpha2[s[0]] = s[1];
      alpha3[s[1]] = s[0];
      numeric[s[2]] = s[0];
      invertedNumeric[s[0]] = s[2];
    });
    function formatNumericCode(code) {
      return String("000" + (code ? code : "")).slice(-3);
    }
    function hasOwnProperty(object, property) {
      return Object.prototype.hasOwnProperty.call(object, property);
    }
    function localeFilter(localeList, filter) {
      return Object.keys(localeList).reduce(function(newLocaleList, alpha22) {
        const nameList = localeList[alpha22];
        newLocaleList[alpha22] = filter(nameList, alpha22);
        return newLocaleList;
      }, {});
    }
    function filterNameBy(type, countryNameList) {
      switch (type) {
        case "official":
          return Array.isArray(countryNameList) ? countryNameList[0] : countryNameList;
        case "all":
          return typeof countryNameList === "string" ? [countryNameList] : countryNameList;
        case "alias":
          return Array.isArray(countryNameList) ? countryNameList[1] || countryNameList[0] : countryNameList;
        default:
          throw new TypeError(
            "LocaleNameType must be one of these: all, official, alias!"
          );
      }
    }
    exports.registerLocale = function(localeData) {
      if (!localeData.locale) {
        throw new TypeError("Missing localeData.locale");
      }
      if (!localeData.countries) {
        throw new TypeError("Missing localeData.countries");
      }
      registeredLocales[localeData.locale] = localeData.countries;
    };
    function alpha3ToAlpha2(code) {
      return alpha3[code];
    }
    exports.alpha3ToAlpha2 = alpha3ToAlpha2;
    function alpha2ToAlpha3(code) {
      return alpha2[code];
    }
    exports.alpha2ToAlpha3 = alpha2ToAlpha3;
    function alpha3ToNumeric(code) {
      return invertedNumeric[alpha3ToAlpha2(code)];
    }
    exports.alpha3ToNumeric = alpha3ToNumeric;
    function alpha2ToNumeric(code) {
      return invertedNumeric[code];
    }
    exports.alpha2ToNumeric = alpha2ToNumeric;
    function numericToAlpha3(code) {
      const padded = formatNumericCode(code);
      return alpha2ToAlpha3(numeric[padded]);
    }
    exports.numericToAlpha3 = numericToAlpha3;
    function numericToAlpha2(code) {
      const padded = formatNumericCode(code);
      return numeric[padded];
    }
    exports.numericToAlpha2 = numericToAlpha2;
    function toAlpha3(code) {
      if (typeof code === "string") {
        if (/^[0-9]*$/.test(code)) {
          return numericToAlpha3(code);
        }
        if (code.length === 2) {
          return alpha2ToAlpha3(code.toUpperCase());
        }
        if (code.length === 3) {
          return code.toUpperCase();
        }
      }
      if (typeof code === "number") {
        return numericToAlpha3(code);
      }
      return void 0;
    }
    exports.toAlpha3 = toAlpha3;
    function toAlpha2(code) {
      if (typeof code === "string") {
        if (/^[0-9]*$/.test(code)) {
          return numericToAlpha2(code);
        }
        if (code.length === 2) {
          return code.toUpperCase();
        }
        if (code.length === 3) {
          return alpha3ToAlpha2(code.toUpperCase());
        }
      }
      if (typeof code === "number") {
        return numericToAlpha2(code);
      }
      return void 0;
    }
    exports.toAlpha2 = toAlpha2;
    exports.getName = function(code, lang, options = {}) {
      if (!("select" in options)) {
        options.select = "official";
      }
      try {
        const codeMaps = registeredLocales[lang.toLowerCase()];
        const nameList = codeMaps[toAlpha2(code)];
        return filterNameBy(options.select, nameList);
      } catch (err) {
        return void 0;
      }
    };
    exports.getNames = function(lang, options = {}) {
      if (!("select" in options)) {
        options.select = "official";
      }
      const localeList = registeredLocales[lang.toLowerCase()];
      if (localeList === void 0) return {};
      return localeFilter(localeList, function(nameList) {
        return filterNameBy(options.select, nameList);
      });
    };
    exports.getAlpha2Code = function(name, lang) {
      const normalizeString = (string) => string.toLowerCase();
      const areSimilar = (a, b) => normalizeString(a) === normalizeString(b);
      try {
        const codenames = registeredLocales[lang.toLowerCase()];
        for (const p in codenames) {
          if (!hasOwnProperty(codenames, p)) {
            continue;
          }
          if (typeof codenames[p] === "string") {
            if (areSimilar(codenames[p], name)) {
              return p;
            }
          }
          if (Array.isArray(codenames[p])) {
            for (const mappedName of codenames[p]) {
              if (areSimilar(mappedName, name)) {
                return p;
              }
            }
          }
        }
        return void 0;
      } catch (err) {
        return void 0;
      }
    };
    exports.getSimpleAlpha2Code = function(name, lang) {
      const normalizeString = (string) => removeDiacritics(string.toLowerCase());
      const areSimilar = (a, b) => normalizeString(a) === normalizeString(b);
      try {
        const codenames = registeredLocales[lang.toLowerCase()];
        for (const p in codenames) {
          if (!hasOwnProperty(codenames, p)) {
            continue;
          }
          if (typeof codenames[p] === "string") {
            if (areSimilar(codenames[p], name)) {
              return p;
            }
          }
          if (Array.isArray(codenames[p])) {
            for (const mappedName of codenames[p]) {
              if (areSimilar(mappedName, name)) {
                return p;
              }
            }
          }
        }
        return void 0;
      } catch (err) {
        return void 0;
      }
    };
    exports.getAlpha2Codes = function() {
      return alpha2;
    };
    exports.getAlpha3Code = function(name, lang) {
      const alpha22 = exports.getAlpha2Code(name, lang);
      if (alpha22) {
        return exports.toAlpha3(alpha22);
      } else {
        return void 0;
      }
    };
    exports.getSimpleAlpha3Code = function(name, lang) {
      const alpha22 = exports.getSimpleAlpha2Code(name, lang);
      if (alpha22) {
        return exports.toAlpha3(alpha22);
      } else {
        return void 0;
      }
    };
    exports.getAlpha3Codes = function() {
      return alpha3;
    };
    exports.getNumericCodes = function() {
      return numeric;
    };
    exports.langs = function() {
      return Object.keys(registeredLocales);
    };
    exports.getSupportedLanguages = function() {
      return supportedLocales;
    };
    exports.isValid = function(code) {
      if (!code) {
        return false;
      }
      const coerced = code.toString().toUpperCase();
      return hasOwnProperty(alpha3, coerced) || hasOwnProperty(alpha2, coerced) || hasOwnProperty(numeric, coerced);
    };
  }
});
export default require_i18n_iso_countries();
