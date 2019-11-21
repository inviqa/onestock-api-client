Feature: Exporting order
    In order to make the order fulfillment process more efficient
    As a warehouse administrator
    I should be able to send the order to OneStock

    Scenario: Successfully exporting an order with a single product
        Given the following order is received
        | order_id | order_total |  |
        And the order 
