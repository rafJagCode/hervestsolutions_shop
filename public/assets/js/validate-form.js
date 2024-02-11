const isNotEmpty = (value) => value && value.trim().length;

const isEqual = (value, payload) => value === $(`[name="${payload}"]`)[0].value;

const isEmail = (value) =>
  value.match(/^([a-z0-9_\.\+-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/);

const isPhone = (value) =>
  value.match(
    /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/
  );

const hasMinLength = (value, payload) => value.trim().length >= +payload;

const hasMaxLength = (value, payload) => value.trim().length <= +payload;

const fields = new Map([
  ["password", "Hasło"],
  ["currentPassword", "Obecne Hasło"],
  ["newPassword", "Nowe Hasło"],
  ["repeatPassword", "Powtórz Hasło"],
  ["country", "Kraj"],
  ["city", "Miasto i Kod Pocztowy"],
  ["street", "Ulica i Numer Budynku"],
  ["firstName", "Imię"],
  ["lastName", "Nazwisko"],
  ["phone", "Numer Telefonu"],
  ["email", "Email"],
]);

const t = (field) => fields.get(field);

const check = new Map([
  ["required", isNotEmpty],
  ["email", isEmail],
  ["phone", isPhone],
  ["minLength", hasMinLength],
  ["maxLength", hasMaxLength],
  ["compare", isEqual],
]);

const messages = new Map([
  ["required", (field) => `<li>Pole ${t(field)} musi być wypełnione.</li>`],
  ["email", () => `<li>Podany email ma nieprawidłowy format.</li>`],
  ["phone", () => `<li>Podany numer telefonu ma nieprawidłowy format.</li>`],
  [
    "minLength",
    (field, payload) =>
      `<li>Pole ${t(
        field
      )} musi być zawierać przynajmniej ${payload} znaków.</li>`,
  ],
  [
    "maxLength",
    (field) =>
      `<li>Pole ${t(
        field
      )} nie może zawierać więcej niż ${payload} znaków.</li>`,
  ],
  [
    "compare",
    (field, payload) =>
      `<li>Pole ${t(payload)} i pole ${t(field)} muszą być takie same.</li>`,
  ],
]);

const validateForm = (form, e) => {
  const inputs = $(form).find(":input");

  const inputsData = inputs
    .map((_, input) => ({
      name: input.name,
      value: input.value,
      validate: $(input).data("validate")?.split(","),
    }))
    .get();

  const incorrect = [];

  for (const data of inputsData) {
    if (!data.validate) continue;

    for (const setting of data.validate) {
      const [rule, payload] = setting.split("-");
      if (check.get(rule)(data.value, payload)) continue;
      incorrect.push({
        field: data.name,
        rule,
        payload,
      });
      break;
    }
  }

  if (!incorrect.length) return;

  e.preventDefault();

  const message = incorrect.reduce(
    (acc, curr) => (acc += messages.get(curr.rule)(curr.field, curr.payload)),
    ""
  );
  addFlash(`<ul>${message}</ul>`);
};
