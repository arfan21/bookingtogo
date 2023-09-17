package customerdomain

import (
	"encoding/json"
	"log"
	"time"

	"github.com/arfan21/bookingtogo/constant"
	"github.com/arfan21/bookingtogo/family/familydomain"
	"github.com/arfan21/bookingtogo/nationality/nationalitydomain"
)

type Customer struct {
	CstID       int                           `json:"-"`
	CstName     string                        `json:"nama"`
	CstDOB      time.Time                     `json:"tanggal_lahir"`
	CstPhoneNum string                        `json:"telepon"`
	CstEmail    string                        `json:"email"`
	NationalID  int                           `json:"-"`
	Nationality nationalitydomain.Nationality `json:"kewarganegaraan"`
}

type CustomerResponse struct {
	CstID       int                           `json:"-"`
	CstName     string                        `json:"nama"`
	CstDOB      time.Time                     `json:"tanggal_lahir"`
	CstPhoneNum string                        `json:"telepon"`
	CstEmail    string                        `json:"email"`
	NationalID  int                           `json:"-"`
	Family      []familydomain.FamilyResponse `json:"keluarga"`
	Nationality nationalitydomain.Nationality `json:"kewarganegaraan,omitempty"`
}

func (c *CustomerResponse) MarshalJSON() ([]byte, error) {
	type Alias CustomerResponse
	log.Println("custom marshal")
	return json.Marshal(&struct {
		Alias
		CstDOB      string `json:"tanggal_lahir"`
		Nationality string `json:"kewarganegaraan"`
	}{
		Alias:       (Alias)(*c),
		CstDOB:      c.CstDOB.Format(constant.DOBFormat),
		Nationality: c.Nationality.String(),
	})
}

func (c *CustomerResponse) FromDB(cst Customer) {
	c.CstID = cst.CstID
	c.CstName = cst.CstName
	c.CstDOB = cst.CstDOB
	c.CstPhoneNum = cst.CstPhoneNum
	c.CstEmail = cst.CstEmail
	c.NationalID = cst.NationalID
	c.Nationality = cst.Nationality
}

type CustomerListResponse struct {
	CstID       int       `json:"customer_id,omitempty"`
	CstName     string    `json:"nama"`
	CstDOB      time.Time `json:"tanggal_lahir"`
	CstPhoneNum string    `json:"telepon"`
	CstEmail    string    `json:"email"`
}

func (c *CustomerListResponse) MarshalJSON() ([]byte, error) {
	type Alias CustomerListResponse
	return json.Marshal(&struct {
		Alias
		CstDOB string `json:"tanggal_lahir"`
	}{
		Alias:  (Alias)(*c),
		CstDOB: c.CstDOB.Format(constant.DOBFormat),
	})
}

func (c *CustomerListResponse) FromDB(cst Customer) {
	c.CstID = cst.CstID
	c.CstName = cst.CstName
	c.CstDOB = cst.CstDOB
	c.CstPhoneNum = cst.CstPhoneNum
	c.CstEmail = cst.CstEmail
}
