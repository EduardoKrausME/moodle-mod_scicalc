# mod_scicalc — Scientific Calculator (Moodle mod)

**mod_scicalc** adds a modern, lightweight, responsive **Scientific Calculator** activity to a course, built in **JavaScript (client-side)** with a clean UI.

> It does not use `eval()` — expressions are interpreted by a simple parser (tokenization + shunting-yard + RPN), offering more security and control.

## Features

* Moodle activity: **“Scientific Calculator”**
* Responsive interface with buttons:

  * Operations: `+ - * / % ^`
  * Parentheses: `( )`
  * Constants: `pi`, `e`
  * Functions: `sin`, `cos`, `tan`, `asin`, `acos`, `atan`, `sqrt`, `abs`, `ln`, `log`, `exp`, `pow`, `min`, `max`, `floor`, `ceil`, `round`
  * Factorial: `!`
* Input field with **Enter = calculate**
* **Local history** (on the page) with click-to-reuse results
* `course_module_viewed` event triggered when accessing the activity
* No collection of personal data (Privacy Provider `null_provider`)

## How to use

1. In the course, turn editing on.
2. Click **“Add an activity or resource”**.
3. Select **“Scientific Calculator”**.
4. Set the name and (optionally) a description.
5. Save.

When opening the activity, the user will see the calculator with a display, buttons, and history.

## Example expressions

* Basic operations:

  * `2+2*3`
  * `(10-4)/2`
* Power and root:

  * `2^10`
  * `sqrt(9)*2`
* Trigonometry:

  * `sin(pi/2)`
  * `cos(0)`
* Logarithms:

  * `ln(e)`
  * `log(1000)`
* Useful functions:

  * `abs(-12)`
  * `pow(2,8)`
  * `min(10,3)`
  * `max(10,3)`
* Factorial:

  * `5!`

> Tip: function buttons automatically insert `func(` to make it easier.

## Security

* **No `eval()`**
* The plugin interprets expressions via:

  * Tokenization
  * Conversion to RPN (Shunting-yard)
  * RPN evaluation (stack)

This reduces common risks of arbitrary code execution found in `eval`-based calculators.

## 🧩 Compatibility

* Moodle **4.0+**
* Interface based on Moodle’s standard Bootstrap

## Support

For questions, bugs, improvements, or suggestions:

* GitHub Issues:
  [https://github.com/EduardoKrausME/moodle-mod_scicalc/issues](https://github.com/EduardoKrausME/moodle-mod_scicalc/issues)

* Direct contact:
  [https://eduardokraus.com/contato](https://eduardokraus.com/contato)

When opening a ticket, it really helps to include:

* Moodle version
* steps to reproduce
* affected provider (component + name)
* a template example (without sensitive data)
* cron / task logs (if it’s about digest)
