class Http {
  constructor() {
    this.baseURL = '/api/'
  }

  getHeaders(isFormData = false) {
    const headers = new Headers();
    if (!isFormData) {
      headers.set("Content-Type", "application/json");
    }
    return headers;
  }

  async get(endpoint) {
    return this.request(endpoint, "GET");
  }

  async post(endpoint, data = {}, isFormData = false) {
    return this.request(endpoint, "POST", data, isFormData);
  }

  async delete(endpoint, data = null, isFormData = false) {
    return this.request(endpoint, "DELETE", data, isFormData);
  }

  // Backward-compatible alias for callers that use del().
  async del(endpoint, data = null, isFormData = false) {
    return this.delete(endpoint, data, isFormData);
  }

  async request(endpoint, method = "GET", data = null, isFormData = false) {
    let  url = '';
    try {
      // თუ endpoint უკვე სრული URL-ია (http:// ან https://), ის იმუშავებს აქ
      url = new URL(endpoint).href;
    } catch (e) {
      // თუ არაა სრული URL, მივამატოთ baseURL
      url = this.baseURL + endpoint;
    }

    const headers = this.getHeaders(isFormData);

    const options = {
      method,
      headers,
    };

    if (data && method !== "GET") {
      options.body = isFormData ? data : JSON.stringify(data);
    }
    try {
      const response = await fetch(url, options);

      const contentType = response.headers.get("Content-Type");
      const isJson = contentType && contentType.includes("application/json");

      const rawData = isJson ? await response.json() : await response.text();

      if (!response.ok) {
        const error = new Error('დაფიქსირდა შეცდომა');
        error.data = rawData;
        error.status = response.status;
        throw error;
      }
      return rawData;
    } catch (error) {
      throw error;
    }

  }
}

export default new Http();