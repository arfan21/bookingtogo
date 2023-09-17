package nationalitydomain

type Nationality struct {
	NationalID   int    `json:"national_id"`
	NationalName string `json:"national_name"`
	NationalCode string `json:"national_code"`
}

// String return formated string inculde name & code,
// example: "Indonesia (ID)"
func (n Nationality) String() string {
	return n.NationalName + " (" + n.NationalCode + ")"
}
