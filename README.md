# Predefined filters module

Main ideas of predefined filters:
* implement a mechanism for creating filters that does not depend on the html form
* realize the ability to create dynamic filters

Dynamic filters realized only for dates fields. For example, if we often need to sort the number of orders 
made since last Friday, it would be convenient to create a dynamic filter with the value {"ordertime": "last Friday"}, 
which always converts this value to the current date on the fly.