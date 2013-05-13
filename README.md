Mageconsult_ThemeSwitcher
=========================

Switch theme without creating a storeview. 

Sometimes you want to test some little new feature in an A/B-test or multivariate test in your testing-tool like http://visualwebsiteoptimizer.com/.

The normal way for doing this is to create a new theme, then create a new storeview and reference that them.

With this little tool you can switch your current theme directly to the new theme with the parameter ___theme=<mynewtheme>

For example:
www.mymagentostore.com/?___theme=blank

The selected theme will be saved in a cookie. You can configure the cookie-lifetime and the allowed themes in your backend-configuration
