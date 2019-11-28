Feature: Exporting order
    In order to make the order fulfillment process more efficient
    As a warehouse administrator
    I should be able to send the order to OneStock

    Scenario: Successfully exporting an order with a single product
        Given the following order has been placed
            | id   | ruleset_id | sales_channel | title | first_name | last_name | phone_number | email                 |
            | 1239 | test       | test_uk       | Mr    | Joe        | Bloggs    | 01475 123456 | joa.bloggs@inviqa.com |
        And order with id "1239" is delivered to the following address
            | shipping_country_code | shipping_postcode | shipping_city | shipping_address_line_1 | shipping_address_line_2 |
            | FR                    | 123456            | Paris         | test address 1          | door 3                  |
        And order with id "1239" has the following billing address
            | billing_country_code | billing_postcode | billing_city | billing_address_line_1 | billing_address_line_2 |
            | FR                   | 123456           | Paris        | test address 1         | door 3                 |
        And order with id "1239" contains the following line items
            | item_id    | item_price |
            | 1100722044 | 100        |
        And the order "1239" has the following payment
            | price | currency | shipping_amount |
            | 100   | EUR      | 7               |
        When order 1239 is exported
        Then the export for order 1239 should be successful
