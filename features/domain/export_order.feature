Feature: Exporting order
    In order to make the order fulfillment process more efficient
    As a warehouse administrator
    I should be able to send the order to OneStock

    Background:
        Given the following order has been placed
            | id   | ruleset_id | sales_channel | title | first_name | last_name | phone_number | email                 |
            | 2222 | test       | test_uk       | Mr    | Joe        | Bloggs    | 7989987998   | joa.bloggs@inviqa.com |
        And order with id "2222" is delivered to the following address
            | shipping_country_code | shipping_postcode | shipping_city | shipping_address_line_1 | shipping_address_line_2 |
            | FR                    | 123456            | Paris         | test address 1          | door 3                  |
        And order with id "2222" has the following billing address
            | billing_country_code | billing_postcode | billing_city | billing_address_line_1 | billing_address_line_2 |
            | FR                   | 123456           | Paris        | test address 1         | door 3                 |
        And order with id "2222" contains the following line items
            | id | item_id    | item_price |
            | 12 | 1100722044 | 100        |

    Scenario: Successfully exporting an order with a single product
        Given the order "2222" has the following payment
            | price | currency | shipping_amount |
            | 100   | EUR      | 7               |
        When order 2222 is exported
        Then the export should be successful

    Scenario: Getting a meaningful error when trying to create an order with incorrect parameters
        Given the order "2222" does not have payment data
        When order 2222 is exported
        Then I should get an error with the content:
            """
            There is an error in the given parameters: The currency field is required, but got empty value instead.
            """

    Scenario: Getting a meaningful error when trying to create an order again
        Given the order "2222" has the following payment
            | price | currency | shipping_amount |
            | 100   | EUR      | 7               |
        And the order "2222" already exists in OneStockApi
        When order 2222 is exported
        Then I should get an response error with the content:
            """
            API Error: already_exists
            """
