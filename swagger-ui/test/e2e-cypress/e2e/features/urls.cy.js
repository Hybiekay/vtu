describe("configuration options: `urls` and `urls.primaryName`", () => {
  describe("`urls` only", () => {
    it("should render a list of URLs correctly", () => {
      cy.visit("/?configUrl=/configs/urls.yaml")
        .get("select")
        .children()
        .should("have.length", 2)
        .get("select > option")
        .eq(0)
        .should("have.text", "One")
        .should("have.attr", "value", )
        .and("match", /\/documents\/features\/urls\/1\.yaml$/)
        .get("select > option")
        .eq(1)
        .should("have.text", "Two")
        .should("have.attr", "value")
        .and("match", /\/documents\/features\/urls\/2\.yaml$/)
    })

    it("should render the first URL in the list", () => {
      cy.visit("/?configUrl=/configs/urls.yaml")
        .get("h2.title")
        .should("have.text", "OneOAS 2.0")
        .window()
        .then(win => win.ui.specSelectors.url())
        .should("match", /\/documents\/features\/urls\/1\.yaml$/)
    })
  })

  it("should respect a `urls.primaryName`", () => {
    cy.visit("/?configUrl=/configs/urls-primary-name.yaml")
      .get("select")
      .should("contain.value", "/documents/features/urls/2.yaml")
      .get("h2.title")
      .should("have.text", "TwoOAS 3.0")
      .window()
      .then(win => win.ui.specSelectors.url())
      .get("select")
      .should("contain.value", "/documents/features/urls/2.yaml")
  })
})

describe("urls with server variables", () => {
  it("should compute a url and default server variables", () => {
    cy.visit("/?configUrl=/configs/urls-server-variables.yaml")
      .get("code")
      .should("have.text", "https://localhost:3200/oneFirstUrl")
      .get("tr > :nth-child(1)")
      .should("have.text", "basePath")
      .get("input")
      .should("have.value", "/oneFirstUrl")
  })
  it("should change server variables", () => {
    cy.visit("/?configUrl=/configs/urls-server-variables.yaml")
      .get("code")
      .should("have.text", "https://localhost:3200/oneFirstUrl")
      .get("tr > :nth-child(1)")
      .should("have.text", "basePath")
      .get("input")
      .should("have.value", "/oneFirstUrl")
      .get(".servers > label > select")
      .eq(0)
      .select(1)
      .get("input")
      .should("have.value", "/oneSecondUrl")
  })
  it("should select and compute second url", () => {
    cy.visit("/?configUrl=/configs/urls-server-variables.yaml")
      .get("select > option")
      .eq(1)
      .should("have.text", "Two")
      .get("select")
      .eq(0)
      .select(1)
      .get("code")
      .should("have.text", "https://localhost:3200/twoFirstUrl")
      .get("input")
      .should("have.value", "/twoFirstUrl")
  })
  it("should select second url, then toggle back to first url", () => {
    cy.visit("/?configUrl=/configs/urls-server-variables.yaml")
      .get("select > option")
      .get("select")
      .eq(0)
      .select(1)
      .get("input")
      .should("have.value", "/twoFirstUrl")
      // toggle url back
      .get("select")
      .eq(0)
      .select(0)
      .get("code")
      .should("have.text", "https://localhost:3200/oneFirstUrl")
      .get("input")
      .should("have.value", "/oneFirstUrl")
  })
  it("should change server variables, then select second url, and maintain server variables index", () => {
    cy.visit("/?configUrl=/configs/urls-server-variables.yaml")
      .get(".servers > label >select")
      .eq(0)
      .select(1)
      .get("input")
      .should("have.value", "/oneSecondUrl")
      // change url
      .get("select > option")
      .get("select")
      .eq(0)
      .select(1)
      .get("input")
      .should("have.value", "/twoSecondUrl")
      .get("input")
      .should("have.value", "/twoSecondUrl")
  })
})
